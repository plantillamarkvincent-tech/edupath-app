<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentRequest;
use App\Models\Student;
use App\Models\Program;
use App\Notifications\EnrollmentRequestApproved;
use App\Notifications\EnrollmentRequestRejected;
use App\Services\SmsService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminEnrollmentRequestController extends Controller
{
    public function index(Request $request): View|\Symfony\Component\HttpFoundation\StreamedResponse
    {
        $query = EnrollmentRequest::with('program');

        // Date range filter
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($programId = $request->integer('program_id')) {
            if ($programId > 0) {
                $query->where('program_id', $programId);
            }
        }

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('contact_number', 'like', "%$search%");
            });
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');
        $allowedSorts = ['created_at', 'full_name', 'status', 'email'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderByDesc('created_at');
        }

        // Statistics (before pagination)
        $stats = [
            'total' => EnrollmentRequest::count(),
            'pending' => EnrollmentRequest::where('status', 'pending')->count(),
            'review' => EnrollmentRequest::where('status', 'review')->count(),
            'approved' => EnrollmentRequest::where('status', 'approved')->count(),
            'rejected' => EnrollmentRequest::where('status', 'rejected')->count(),
            'today' => EnrollmentRequest::whereDate('created_at', today())->count(),
            'this_week' => EnrollmentRequest::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => EnrollmentRequest::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
        ];

        if ($request->string('export')->toString() === 'csv') {
            $filename = 'enrollment_requests_'.now()->format('Ymd_His').'.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ];
            return response()->stream(function () use ($query) {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['ID','Submitted','Full Name','Email','Contact','Program','Status']);
                $query->orderByDesc('created_at')->chunk(500, function ($chunk) use ($out) {
                    foreach ($chunk as $req) {
                        fputcsv($out, [
                            $req->id,
                            optional($req->created_at)->toDateTimeString(),
                            $req->full_name,
                            $req->email,
                            $req->contact_number ?? '',
                            optional($req->program)->name,
                            $req->status,
                        ]);
                    }
                });
                fclose($out);
            }, 200, $headers);
        }

        $requests = $query->paginate(20)->withQueryString();
        $programs = Program::orderBy('name')->get();
        return view('admin.enrollment_requests.index', compact('requests','programs', 'stats', 'sortBy', 'sortDir'));
    }

    public function show(EnrollmentRequest $enrollmentRequest): View
    {
        $enrollmentRequest->load('program');
        return view('admin.enrollment_requests.show', compact('enrollmentRequest'));
    }

    public function print(EnrollmentRequest $enrollmentRequest): View
    {
        $enrollmentRequest->load('program');
        return view('admin.enrollment_requests.spf_view', compact('enrollmentRequest'));
    }

    public function approve(EnrollmentRequest $enrollmentRequest, SmsService $sms): RedirectResponse
    {
        $this->processApprove($enrollmentRequest, $sms);
        return back()->with('status', 'Enrollment request approved and student created/linked.');
    }

    public function reject(Request $request, EnrollmentRequest $enrollmentRequest, SmsService $sms): RedirectResponse
    {
        $data = $request->validate([
            'admin_note' => ['nullable','string','max:2000'],
        ]);

        $this->processReject($enrollmentRequest, $sms, $data['admin_note'] ?? null);

        return back()->with('status', 'Enrollment request rejected.');
    }

    public function bulkAction(Request $request, SmsService $sms): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required','in:approve,reject'],
            'selected_requests' => ['required','array','min:1'],
            'selected_requests.*' => ['integer','exists:enrollment_requests,id'],
            'admin_note' => ['nullable','string','max:2000'],
        ]);

        $requests = EnrollmentRequest::whereIn('id', $validated['selected_requests'])->get();
        $approvedCount = 0;
        $rejectedCount = 0;

        foreach ($requests as $enrollmentRequest) {
            if ($validated['action'] === 'approve') {
                $this->processApprove($enrollmentRequest, $sms);
                $approvedCount++;
            } else {
                $this->processReject($enrollmentRequest, $sms, $validated['admin_note'] ?? null);
                $rejectedCount++;
            }
        }

        $message = $validated['action'] === 'approve'
            ? "Approved {$approvedCount} request(s)."
            : "Rejected {$rejectedCount} request(s).";

        return back()->with('status', $message);
    }

    /**
     * Handle the full approval workflow without returning a redirect.
     */
    private function processApprove(EnrollmentRequest $enrollmentRequest, SmsService $sms): void
    {
        $enrollmentRequest->update(['status' => 'approved']);

        // Ensure a student record exists
        $user = User::firstOrCreate(
            ['email' => $enrollmentRequest->email],
            ['name' => $enrollmentRequest->full_name, 'password' => bcrypt(str()->random(12))]
        );

        $student = Student::firstOrCreate(
            ['user_id' => $user->id],
            [
                'student_number' => 'S'.now()->format('Y').$user->id,
                'first_name' => $enrollmentRequest->full_name,
                'last_name' => '',
                'contact_number' => $enrollmentRequest->contact_number,
                'address' => $enrollmentRequest->address,
                'program_id' => $enrollmentRequest->program_id,
                'status' => 'active',
            ]
        );

        // Auto-create initial term enrollments (optional): enroll in program's first semester courses
        $initialCourses = optional($enrollmentRequest->program)->courses()
            ?->where('year_level', 1)->where('semester', 1)->get() ?? collect();
        foreach ($initialCourses as $course) {
            \App\Models\Enrollment::firstOrCreate([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'term' => '1st',
                'school_year' => $enrollmentRequest->school_year,
            ]);
        }

        // Notify student via email
        if ($enrollmentRequest->email) {
            $user->notify(new EnrollmentRequestApproved([
                'full_name' => $enrollmentRequest->full_name,
                'program_name' => optional($enrollmentRequest->program)->name,
            ]));
        }

        // SMS notify admins (or a configured number)
        $adminNumber = config('services.sms.admin_number');
        if ($adminNumber) {
            $sms->send($adminNumber, 'Enrollment approved: '.$enrollmentRequest->full_name.' - '.optional($enrollmentRequest->program)->name);
        }
    }

    /**
     * Handle the rejection workflow without returning a redirect.
     */
    private function processReject(EnrollmentRequest $enrollmentRequest, SmsService $sms, ?string $adminNote = null): void
    {
        $enrollmentRequest->update([
            'status' => 'rejected',
            'admin_note' => $adminNote,
        ]);

        // Email notify student
        if ($enrollmentRequest->email) {
            $user = User::firstOrNew(['email' => $enrollmentRequest->email]);
            $user->notify(new EnrollmentRequestRejected([
                'full_name' => $enrollmentRequest->full_name,
                'program_name' => optional($enrollmentRequest->program)->name,
            ]));
        }

        // SMS notify admins
        $adminNumber = config('services.sms.admin_number');
        if ($adminNumber) {
            $sms->send($adminNumber, 'Enrollment rejected: '.$enrollmentRequest->full_name.' - '.optional($enrollmentRequest->program)->name);
        }
    }

    public function edit(EnrollmentRequest $enrollmentRequest): View
    {
        $columns = \Schema::getColumnListing('enrollment_requests');
        return view('admin.enrollment_requests.edit', compact('enrollmentRequest','columns'));
    }

    public function update(Request $request, EnrollmentRequest $enrollmentRequest): RedirectResponse
    {
        $columns = collect(\Schema::getColumnListing('enrollment_requests'))
            ->diff(['id','user_id','created_at','updated_at']);

        $input = $request->only($columns->toArray());

        // Handle optional photo replace
        if ($request->hasFile('student_photo')) {
            $photo = $request->file('student_photo');
            $photoName = time().'_'.$photo->getClientOriginalName();
            $photoPath = $photo->storeAs('student_photos', $photoName, 'public');
            $input['student_photo'] = $photoPath;
        }

        $enrollmentRequest->fill($input);
        $enrollmentRequest->save();

        return redirect()->route('admin.enrollment_requests.show', $enrollmentRequest)
            ->with('status', 'SPF updated successfully.');
    }

    public function destroy(EnrollmentRequest $enrollmentRequest): RedirectResponse
    {
        $enrollmentRequest->delete();
        return redirect()->route('admin.enrollment_requests.index')
            ->with('status', 'Enrollment request deleted.');
    }

    public function restore(int $id): RedirectResponse
    {
        $req = EnrollmentRequest::withTrashed()->findOrFail($id);
        $req->restore();
        return back()->with('status', 'Enrollment request restored.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $req = EnrollmentRequest::withTrashed()->findOrFail($id);
        $req->forceDelete();
        return back()->with('status', 'Enrollment request permanently deleted.');
    }
}


