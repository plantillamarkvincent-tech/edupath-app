<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\EnrollmentRequest;
use App\Notifications\NewAnnouncementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AnnouncementController extends Controller
{
    public function submitAnnouncement(Request $request)
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

        // Get emails of students who have submitted their requirements (enrollment requests)
        $recipientEmails = EnrollmentRequest::whereNotNull('email')
            ->pluck('email')
            ->unique()
            ->toArray();

        // Send notification emails via Gmail to each student
        foreach ($recipientEmails as $email) {
            Mail::to($email)->send(new NewAnnouncementNotification($announcement));
        }

        return response()->json([
            'message' => 'Announcement submitted successfully. Notifications sent to ' . count($recipientEmails) . ' students.',
            'announcement' => $announcement
        ]);
    }
}
