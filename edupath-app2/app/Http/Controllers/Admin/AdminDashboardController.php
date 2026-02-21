<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentRequest;
use App\Models\Student;
use App\Models\Program;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Get enrollment request counts for dashboard cards
        $totalRequests = EnrollmentRequest::count();
        $pendingCount = EnrollmentRequest::where('status', 'pending')->count();
        $approvedCount = EnrollmentRequest::where('status', 'approved')->count();
        $rejectedCount = EnrollmentRequest::where('status', 'rejected')->count();

        // For the enrollment requests table
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
        $systemStatus = Setting::get('system_status', 'online');
        
        return view('admin.dashboard', [
            'enrollmentRequests' => $requests,
            'programs' => $programs,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'program_id' => $programId,
                'status' => $status,
                'search' => $search,
            ],
            'totalRequests' => $totalRequests,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'stats' => $stats,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
            'systemStatus' => $systemStatus,
        ]);
    }

    public function updateSystemStatus(Request $request)
    {
        $status = $request->input('status') === 'offline' ? 'offline' : 'online';

        Setting::set('system_status', $status);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'System status updated to '.$status.'.');
    }
}

