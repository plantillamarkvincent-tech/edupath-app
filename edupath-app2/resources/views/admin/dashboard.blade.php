@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">System Status</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                The system is currently
                <span class="font-semibold {{ $systemStatus === 'offline' ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                    {{ strtoupper($systemStatus) }}
                </span>.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <form method="POST" action="{{ route('admin.system-status.update') }}">
                @csrf
                <input type="hidden" name="status" value="online">
                <button type="submit"
                    class="px-4 py-2 rounded-md text-sm font-medium border
                    {{ $systemStatus === 'online'
                        ? 'bg-green-600 text-white border-green-700 hover:bg-green-700'
                        : 'bg-white text-green-700 border-green-600 hover:bg-green-50 dark:bg-gray-900 dark:text-green-400 dark:border-green-500' }}">
                    Set Online
                </button>
            </form>
            <form method="POST" action="{{ route('admin.system-status.update') }}">
                @csrf
                <input type="hidden" name="status" value="offline">
                <button type="submit"
                    class="px-4 py-2 rounded-md text-sm font-medium border
                    {{ $systemStatus === 'offline'
                        ? 'bg-red-600 text-white border-red-700 hover:bg-red-700'
                        : 'bg-white text-red-700 border-red-600 hover:bg-red-50 dark:bg-gray-900 dark:text-red-400 dark:border-red-500' }}">
                    Set Offline
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Dashboard</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Welcome to the admin dashboard.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Requests Card -->
        <a href="{{ route('admin.enrollment_requests.index') }}" class="block hover:opacity-90 transition-opacity">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-blue-500 h-full">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Requests</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalRequests) }}</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Pending Card -->
        <a href="{{ route('admin.enrollment_requests.index', ['status' => 'pending']) }}" class="block hover:opacity-90 transition-opacity">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-yellow-500 h-full">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($pendingCount) }}</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Approved Card -->
        <a href="{{ route('admin.enrollment_requests.index', ['status' => 'approved']) }}" class="block hover:opacity-90 transition-opacity">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-green-500 h-full">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Approved</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($approvedCount) }}</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Rejected Card -->
        <a href="{{ route('admin.enrollment_requests.index', ['status' => 'rejected']) }}" class="block hover:opacity-90 transition-opacity">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-red-500 h-full">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Rejected</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($rejectedCount) }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
