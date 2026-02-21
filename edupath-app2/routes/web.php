<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\EnrollmentRequestController;
use App\Http\Controllers\Admin\AdminEnrollmentRequestController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProgramController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\Admin\AdminAboutController;
use App\Http\Middleware\SystemStatusMiddleware;
use App\Models\AboutPage;

// Simple route to verify DB connection
Route::get('/db-test', function () {
    // If this fails, an exception will be thrown
    DB::connection()->getPdo();
    return 'DB connection OK';
});

Route::middleware(SystemStatusMiddleware::class)->group(function () {
    Route::get('/', [CareerController::class, 'landing'])->name('landing');

// Debug route - remove after testing
Route::get('/debug-user', function() {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'logged_in' => true,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_admin' => $user->isAdmin(),
        ]);
    }
    return response()->json(['logged_in' => false]);
})->middleware('auth');

    Route::get('/career', [CareerController::class, 'index'])->name('career.index');
    Route::get('/career/{program}', [CareerController::class, 'show'])->name('career.show');

    Route::get('/enroll/{program}', [EnrollmentRequestController::class, 'create'])->name('enrollment.create');
    Route::post('/enroll', [EnrollmentRequestController::class, 'store'])->name('enrollment.store');

    // Contact Admin
    Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact/send', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

    // Public About Us page (students and visitors)
    Route::get('/about', function () {
        $about = AboutPage::first();

        if (! $about) {
            $about = new AboutPage([
                'title' => 'About Us',
            ]);
        }

        return view('dashboard', compact('about'));
    })->name('about');

    // Keep /dashboard for authenticated users, but redirect to About page
    Route::get('/dashboard', function () {
        return redirect()->route('about');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/student/dashboard', [App\Http\Controllers\StudentController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('student.dashboard');

    // Student Profile Form
    Route::get('/student/profile-form', function () {
        return view('student.profile-form');
    })->name('student.profile-form');

    // Handle SPF form submission
    Route::post('/student/profile-form/submit', function () {
        // For now, just return a success message
        return response()->json(['message' => 'Form submitted successfully!']);
    })->name('student.profile-form.submit');

    // Test route to check if changes are working
    Route::get('/test-form', function () {
        return view('test-form');
    })->name('test.form');

    // New SPF form route with different name
    Route::get('/spf-form-new', function () {
        return view('spf-form-new');
    })->name('spf.form.new');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';

// Admin routes
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/system-status', [AdminDashboardController::class, 'updateSystemStatus'])->name('system-status.update');
    Route::get('/about', [AdminAboutController::class, 'edit'])->name('about.edit');
    Route::put('/about', [AdminAboutController::class, 'update'])->name('about.update');
    Route::get('/enrollment-requests', [AdminEnrollmentRequestController::class, 'index'])->name('enrollment_requests.index');
    Route::get('/enrollment-requests/{enrollmentRequest}', [AdminEnrollmentRequestController::class, 'show'])->name('enrollment_requests.show');
    Route::get('/enrollment-requests/{enrollmentRequest}/print', [AdminEnrollmentRequestController::class, 'print'])->name('enrollment_requests.print');
    Route::get('/enrollment-requests/{enrollmentRequest}/edit', [AdminEnrollmentRequestController::class, 'edit'])->name('enrollment_requests.edit');
    Route::put('/enrollment-requests/{enrollmentRequest}', [AdminEnrollmentRequestController::class, 'update'])->name('enrollment_requests.update');
    Route::delete('/enrollment-requests/{enrollmentRequest}', [AdminEnrollmentRequestController::class, 'destroy'])->name('enrollment_requests.destroy');
    Route::post('/enrollment-requests/{enrollmentRequest}/approve', [AdminEnrollmentRequestController::class, 'approve'])->name('enrollment_requests.approve');
    Route::post('/enrollment-requests/{enrollmentRequest}/reject', [AdminEnrollmentRequestController::class, 'reject'])->name('enrollment_requests.reject');
    Route::post('/enrollment-requests/bulk-action', [AdminEnrollmentRequestController::class, 'bulkAction'])->name('enrollment_requests.bulk_action');

    // Restore/Force Delete soft-deleted enrollment requests (used in Backup page)
    Route::post('/enrollment-requests/{id}/restore', [AdminEnrollmentRequestController::class, 'restore'])->name('enrollment_requests.restore');
    Route::delete('/enrollment-requests/{id}/force-delete', [AdminEnrollmentRequestController::class, 'forceDelete'])->name('enrollment_requests.force_delete');

    // Backup & Restore
    Route::get('/backup', [App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup/create', [App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create');
    Route::get('/backup/download/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download');
    Route::post('/backup/restore/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'restore'])->name('backup.restore');
    Route::delete('/backup/delete/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'delete'])->name('backup.delete');

    // Programs management
    Route::get('/programs', [AdminProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/create', [AdminProgramController::class, 'create'])->name('programs.create');
    Route::post('/programs', [AdminProgramController::class, 'store'])->name('programs.store');
    Route::get('/programs/{program}/edit', [AdminProgramController::class, 'edit'])->name('programs.edit');
    Route::put('/programs/{program}', [AdminProgramController::class, 'update'])->name('programs.update');
    Route::delete('/programs/{program}', [AdminProgramController::class, 'destroy'])->name('programs.destroy');

    // Students management
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');

    // Announcements management
    Route::resource('announcements', AdminAnnouncementController::class);

    // Messages inbox (student -> admin)
    Route::get('/messages', [App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');

    // Courses management (subjects per program)
    Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [AdminCourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');
});

// Announcement submission route (accessible to authenticated users, perhaps admins)
Route::middleware(['auth', SystemStatusMiddleware::class])->group(function () {
    Route::post('/announcements/submit', [App\Http\Controllers\AnnouncementController::class, 'submitAnnouncement'])->name('announcements.submit');
});
