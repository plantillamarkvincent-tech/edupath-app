@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-6">

    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-2">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Enrollment Requests Dashboard</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage and track all student enrollment requests</p>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-lg font-medium border border-emerald-200 dark:border-emerald-800">{{ session('status') }}</div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg font-medium border border-red-200 dark:border-red-800">{{ session('error') }}</div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
            <p class="text-sm text-gray-600 dark:text-gray-400">Today</p>
            <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $stats['today'] ?? 0 }} requests</p>
        </div>
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg p-4 border border-indigo-200 dark:border-indigo-800">
            <p class="text-sm text-gray-600 dark:text-gray-400">This Week</p>
            <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $stats['this_week'] ?? 0 }} requests</p>
        </div>
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
            <p class="text-sm text-gray-600 dark:text-gray-400">This Month</p>
            <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $stats['this_month'] ?? 0 }} requests</p>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 p-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Statuses</option>
                        @foreach (['pending','review','approved','rejected'] as $s)
                            <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Program</label>
                    <select name="program_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Programs</option>
                        @foreach ($programs as $p)
                            <option value="{{ $p->id }}" @selected((string)request('program_id')===(string)$p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name, email, or contact number" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition shadow-sm">
                        <span class="hidden sm:inline">Apply</span>
                        <span class="sm:hidden">Filter</span>
                    </button>
                    <a href="{{ route('admin.enrollment_requests.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md font-medium transition">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk Actions & Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <form method="POST" action="{{ route('admin.enrollment_requests.bulk_action') }}">
            @csrf
            <div class="p-4 flex flex-wrap items-center gap-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <select name="action" class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3">
                    <option value="approve">Approve Selected</option>
                    <option value="reject">Reject Selected</option>
                </select>
                <input type="text" name="admin_note" placeholder="Reason (optional for reject)" class="flex-1 min-w-[200px] border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3" />
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition shadow-sm">
                    Apply to Selected
                </button>
                <span class="text-sm text-gray-600 dark:text-gray-400 ml-auto">
                    Showing {{ $requests->firstItem() ?? 0 }}-{{ $requests->lastItem() ?? 0 }} of {{ $requests->total() }} requests
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">
                                <input type="checkbox" onclick="document.querySelectorAll('.req-checkbox').forEach(cb=>cb.checked=this.checked)" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ route('admin.enrollment_requests.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_dir' => $sortBy === 'created_at' && $sortDir === 'desc' ? 'asc' : 'desc'])) }}" class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-100">
                                    Submitted
                                    @if($sortBy === 'created_at')
                                        @if($sortDir === 'asc')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ route('admin.enrollment_requests.index', array_merge(request()->all(), ['sort_by' => 'full_name', 'sort_dir' => $sortBy === 'full_name' && $sortDir === 'desc' ? 'asc' : 'desc'])) }}" class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-100">
                                    Full Name
                                    @if($sortBy === 'full_name')
                                        @if($sortDir === 'asc')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Program</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ route('admin.enrollment_requests.index', array_merge(request()->all(), ['sort_by' => 'status', 'sort_dir' => $sortBy === 'status' && $sortDir === 'desc' ? 'asc' : 'desc'])) }}" class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-100">
                                    Status
                                    @if($sortBy === 'status')
                                        @if($sortDir === 'asc')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($requests as $req)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="checkbox" class="req-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="selected_requests[]" value="{{ $req->id }}" />
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $req->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $req->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $req->full_name }}</div>
                                    @if($req->contact_number)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $req->contact_number }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $req->email }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $req->program?->name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                        @if($req->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                        @elseif($req->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                        @elseif($req->status === 'review') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @endif">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <a href="{{ route('admin.enrollment_requests.show', $req) }}" 
                                           class="inline-flex items-center px-2.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-medium transition shadow-sm">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>

                                        <a href="{{ route('admin.enrollment_requests.edit', $req) }}" 
                                           class="inline-flex items-center px-2.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-xs font-medium transition shadow-sm">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>

                                        @php
                                            $isApproved = trim(strtolower($req->status)) === 'approved';
                                            $isRejected = trim(strtolower($req->status)) === 'rejected';
                                        @endphp

                                        @if(!$isApproved)
                                            <form method="POST" action="{{ route('admin.enrollment_requests.approve', $req) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-medium transition shadow-sm">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if(!$isRejected)
                                            <form method="POST" action="{{ route('admin.enrollment_requests.reject', $req) }}" class="inline" onsubmit="var note = prompt('Reason for rejection (optional):'); if(note === null) { return false; } this.querySelector('input[name=admin_note]').value = note; return true;">
                                                @csrf
                                                <input type="hidden" name="admin_note" value="" />
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium transition shadow-sm">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Reject
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('admin.enrollment_requests.destroy', $req) }}" class="inline" onsubmit="return confirm('Delete this enrollment request? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded text-xs font-medium transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-12 text-center" colspan="7">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No Enrollment Requests Found</h3>
                                        <p class="text-gray-500 dark:text-gray-400 mb-4">No requests match your current filters.</p>
                                        @if(request()->hasAny(['status', 'program_id', 'q', 'date_from', 'date_to']))
                                            <a href="{{ route('admin.enrollment_requests.index') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition">
                                                Clear Filters
                                            </a>
                                        @else
                                            <div class="text-sm text-gray-600 dark:text-gray-400 bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg max-w-md">
                                                <p class="font-semibold mb-2">When students submit their SPF forms, they will appear here.</p>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination -->
        @if($requests->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                {{ $requests->links() }}
            </div>
        @endif
    </div>

    
@endsection


