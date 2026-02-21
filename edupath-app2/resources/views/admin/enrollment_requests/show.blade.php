@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <a href="{{ route('admin.enrollment_requests.index') }}" class="text-sm text-gray-600">← Back</a>
    <h1 class="text-2xl font-semibold mb-4">Enrollment Request</h1>

    @if (session('status'))
        <div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded">{{ session('status') }}</div>
    @endif

    {{-- Status Badge --}}
    <div class="mb-4">
        <span class="px-4 py-2 rounded-lg text-sm font-semibold
            @if($enrollmentRequest->status === 'approved') bg-green-100 text-green-800
            @elseif($enrollmentRequest->status === 'rejected') bg-red-100 text-red-800
            @elseif($enrollmentRequest->status === 'review') bg-yellow-100 text-yellow-800
            @else bg-gray-100 text-gray-800
            @endif">
            Status: {{ ucfirst($enrollmentRequest->status) }}
        </span>
        @if($enrollmentRequest->admin_note)
            <div class="mt-2 p-3 bg-yellow-50 border-l-4 border-yellow-400 text-sm">
                <strong>Admin Note:</strong> {{ $enrollmentRequest->admin_note }}
            </div>
        @endif
    </div>

    <div class="mt-4 flex gap-2 flex-wrap items-center">
        {{-- Edit Button --}}
        <a href="{{ route('admin.enrollment_requests.edit', $enrollmentRequest) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Form
        </a>

        {{-- Print Button --}}
        <a href="{{ route('admin.enrollment_requests.print', $enrollmentRequest) }}" target="_blank" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print SPF
        </a>

        <div class="flex-1"></div>

        {{-- Approve Button --}}
        <form method="POST" action="{{ route('admin.enrollment_requests.approve', $enrollmentRequest) }}">
            @csrf
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold" @disabled($enrollmentRequest->status === 'approved')>
                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ $enrollmentRequest->status === 'approved' ? 'Approved' : 'Approve' }}
            </button>
        </form>

        {{-- Reject Button --}}
        <form method="POST" action="{{ route('admin.enrollment_requests.reject', $enrollmentRequest) }}" class="flex items-center gap-2">
            @csrf
            <input type="text" name="admin_note" placeholder="Reason for rejection (optional)" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" />
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold" @disabled($enrollmentRequest->status === 'rejected')>
                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ $enrollmentRequest->status === 'rejected' ? 'Rejected' : 'Reject' }}
            </button>
        </form>

        {{-- Delete Button (red) --}}
        <form method="POST" action="{{ route('admin.enrollment_requests.destroy', $enrollmentRequest) }}" onsubmit="return confirm('Delete this enrollment request? This cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Delete
            </button>
        </form>
    </div>

    {{-- Show the submitted SPF --}}
    <div class="mt-6">
        <iframe src="{{ route('admin.enrollment_requests.print', $enrollmentRequest) }}" 
                class="w-full border-2 border-gray-300 rounded-lg shadow-lg" 
                style="min-height: 800px;"
                title="Student Profile Form">
        </iframe>
    </div>
</div>
@endsection


