<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactMessageController extends Controller
{
    public function index()
    {
        if (!Schema::hasTable('contact_messages')) {
            $messages = new LengthAwarePaginator([], 0, 15, 1);
            $unread = 0;
            $needsMigration = true;
            return view('admin.messages.index', compact('messages', 'unread', 'needsMigration'));
        }

        $messages = ContactMessage::orderByDesc('created_at')->paginate(15);
        $unread = ContactMessage::where('is_read', false)->count();
        return view('admin.messages.index', compact('messages','unread'));
    }

    public function show(ContactMessage $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('status', 'Message deleted.');
    }
}
