<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupController extends Controller
{
    public function index()
    {
        $backups = collect(Storage::disk('local')->files('backups'))
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => Storage::disk('local')->size($file),
                    'date' => Storage::disk('local')->lastModified($file),
                ];
            })
            ->sortByDesc('date')
            ->values();

        // Load soft-deleted enrollment requests (guard if column not migrated yet)
        if (Schema::hasTable('enrollment_requests') && Schema::hasColumn('enrollment_requests', 'deleted_at')) {
            $deletedRequests = \App\Models\EnrollmentRequest::onlyTrashed()
                ->with('program')
                ->orderByDesc('deleted_at')
                ->paginate(10);
        } else {
            $deletedRequests = new LengthAwarePaginator([], 0, 10, 1);
        }

        return view('admin.backup.index', compact('backups','deletedRequests'));
    }

    public function create()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sqlite';
            $sourcePath = database_path('database.sqlite');
            $backupPath = storage_path('app/backups/' . $filename);

            // Create backups directory if it doesn't exist
            if (!File::exists(storage_path('app/backups'))) {
                File::makeDirectory(storage_path('app/backups'), 0755, true);
            }

            // Copy database file
            File::copy($sourcePath, $backupPath);

            return redirect()->route('admin.backup.index')
                ->with('status', 'Backup created successfully: ' . $filename);
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        $path = 'backups/' . $filename;
        
        if (!Storage::disk('local')->exists($path)) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Backup file not found');
        }

        return Storage::disk('local')->download($path);
    }

    public function restore($filename)
    {
        try {
            $backupPath = storage_path('app/backups/' . $filename);
            $dbPath = database_path('database.sqlite');

            if (!File::exists($backupPath)) {
                return redirect()->route('admin.backup.index')
                    ->with('error', 'Backup file not found');
            }

            // Create a backup of current database before restoring
            $currentBackup = 'backup_before_restore_' . date('Y-m-d_H-i-s') . '.sqlite';
            File::copy($dbPath, storage_path('app/backups/' . $currentBackup));

            // Restore the backup
            File::copy($backupPath, $dbPath);

            return redirect()->route('admin.backup.index')
                ->with('status', 'Database restored successfully from: ' . $filename);
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Restore failed: ' . $e->getMessage());
        }
    }

    public function delete($filename)
    {
        try {
            $path = 'backups/' . $filename;
            
            if (Storage::disk('local')->exists($path)) {
                Storage::disk('local')->delete($path);
                return redirect()->route('admin.backup.index')
                    ->with('status', 'Backup deleted successfully');
            }

            return redirect()->route('admin.backup.index')
                ->with('error', 'Backup file not found');
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}
