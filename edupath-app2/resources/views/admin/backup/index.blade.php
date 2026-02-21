@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-3xl font-bold">Backup Database to Restore</h1>
        <div class="flex items-center gap-3">
            <form method="POST" action="{{ route('admin.backup.create') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 active:scale-[0.99] transition font-semibold shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Create Backup
                </button>
            </form>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg font-medium">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg font-medium">
            {{ session('error') }}
        </div>
    @endif

  
   
    {{-- Deleted Requests Section --}}
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b">
            <h2 class="text-lg font-semibold">Deleted Requests</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Restore or permanently delete soft-deleted enrollment requests.</p>
        </div>

        @if(isset($deletedRequests) && $deletedRequests->count() > 0)
            <table class="min-w-full">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Program</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Deleted At</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($deletedRequests as $req)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-sm">{{ $req->id }}</td>
                            <td class="px-6 py-4 text-sm">{{ $req->full_name }}</td>
                            <td class="px-6 py-4 text-sm">{{ optional($req->program)->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ optional($req->deleted_at)->format('M d, Y h:i A') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form method="POST" action="{{ route('admin.enrollment_requests.restore', $req->id) }}">
                                        @csrf
                                        <button type="submit" class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium transition" style="background-color:#2563eb; color:#ffffff;">Restore</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.enrollment_requests.force_delete', $req->id) }}" onsubmit="return confirm('Permanently delete this request? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium transition">Delete Permanently</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">{{ $deletedRequests->links() }}</div>
        @else
            <div class="p-8 text-center text-gray-600 dark:text-gray-300">No deleted enrollment requests.</div>
        @endif
    </div>

    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border border-blue-200 dark:border-blue-700">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-800 dark:text-blue-200">Important Notes</h4>
                <ul class="text-sm text-blue-700 dark:text-blue-300 mt-2 space-y-1 list-disc list-inside">
                    <li>Backups include all database data (users, students, enrollments, etc.)</li>
                    <li>Before restoring, a backup of the current database is automatically created</li>
                    <li>Download backups regularly to keep them safe</li>
                    <li>Restoring a backup will replace all current data</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
