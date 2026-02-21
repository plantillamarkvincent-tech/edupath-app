<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\EnrollmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('creator')
            ->orderByDesc('created_at')
            ->paginate(10);
        
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['required', 'string', 'in:general,course,class'],
            'publish_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after:publish_at'],
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = true;

        $announcement = Announcement::create($validated);

        // Notify via email only students who have submitted their requirements
        $recipientEmails = EnrollmentRequest::whereNotNull('email')
            ->pluck('email')
            ->unique();

        foreach ($recipientEmails as $email) {
            \Notification::route('mail', $email)
                ->notify(new \App\Notifications\NewAnnouncementNotification($announcement));
        }

        return redirect()
            ->route('admin.announcements.index')
            ->with('status', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
        // Reuse the create/edit form view for editing
        return view('admin.announcements.create', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['required', 'string', 'in:general,course,class'],
            'is_active' => ['boolean'],
            'publish_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after:publish_at'],
        ]);

        $announcement->update($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with('status', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        
        return redirect()
            ->route('admin.announcements.index')
            ->with('status', 'Announcement deleted successfully.');
    }
}