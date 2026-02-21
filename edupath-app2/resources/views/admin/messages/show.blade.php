@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h1 class="text-xl font-semibold">{{ $message->subject }}</h1>
                <p class="text-sm text-gray-500">From {{ $message->name }} · {{ $message->email }} · {{ $message->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($message->email) }}&su={{ rawurlencode('RE: '.$message->subject) }}&body={{ rawurlencode("Hi {$message->name},\n\n\n--- Original Message ---\nFrom: {$message->name} <{$message->email}>\nSent: " . $message->created_at->format('M d, Y h:i A') . "\nSubject: {$message->subject}\n\n{$message->message}\n") }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium border border-blue-700 text-white shadow-sm active:scale-[0.99]"
                   style="background-color:#2563eb; border-color:#1d4ed8;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Reply in Gmail
                </a>
                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?');" class="inline-flex">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm font-medium border border-red-700 shadow-sm active:scale-[0.99]">Delete</button>
                </form>
            </div>
        </div>
        <div class="prose max-w-none">{{ $message->message }}</div>
        <div class="mt-6">
            <a href="{{ route('admin.messages.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Inbox</a>
        </div>
    </div>
</div>
@endsection
