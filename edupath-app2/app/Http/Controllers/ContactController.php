<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Admin email - you can change this
        $adminEmail = env('ADMIN_EMAIL', 'admin@dorsu.edu.ph');

        try {
            // Store to inbox for admin
            ContactMessage::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'is_read' => false,
            ]);

            // Send email to admin
            Mail::raw(
                "Name: {$validated['name']}\n" .
                "Email: {$validated['email']}\n" .
                "Subject: {$validated['subject']}\n\n" .
                "Message:\n{$validated['message']}",
                function ($message) use ($validated, $adminEmail) {
                    $message->to($adminEmail)
                        ->subject('Student Inquiry: ' . $validated['subject'])
                        ->replyTo($validated['email'], $validated['name']);
                }
            );

            return redirect()->route('contact.index')
                ->with('status', 'Your message has been sent successfully! The admin will respond to your email.');
        } catch (\Exception $e) {
            return redirect()->route('contact.index')
                ->with('error', 'Failed to send message. Please try again or contact admin directly at: ' . $adminEmail);
        }
    }
}
