<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Profile (Breeze)
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;

// Teacher Controllers
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\ModuleController as TeacherModuleController;
use App\Http\Controllers\Teacher\LessonController as TeacherLessonController;
use App\Http\Controllers\Teacher\ContentController as TeacherContentController;
use App\Http\Controllers\Teacher\DiscussionController as TeacherDiscussionController;
use App\Http\Controllers\Teacher\PrivateChatController as TeacherPrivateChatController;

// Student Controllers
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\CertificateController as StudentCertificateController;
use App\Http\Controllers\Student\DiscussionController as StudentDiscussionController;
use App\Http\Controllers\Student\PrivateChatController as StudentPrivateChatController;
use App\Http\Controllers\Student\ContentController as StudentContentController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;

use App\Http\Controllers\LessonController;



// Beranda (Livewire page)
Route::get('/', function () {
    // Jika belum login → tampilkan homepage
    if (!Auth::check()) {
        // resources/views/guest/dashboard.blade.php
        return view('guest.dashboard');
    }

    // Jika sudah login → masuk sesuai role
    $user = Auth::user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'teacher' => redirect()->route('teacher.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => redirect()->route('home'),
    };
})->name('home');


// ==============================
// KATALOG & DETAIL COURSE (PUBLIC + STUDENT)
// ==============================

// Katalog course → guest: view('guest.courses.index')
//                 student: view('student.courses.catalog')
Route::get('/courses', [StudentCourseController::class, 'catalog'])
    ->name('courses.index');

// Detail course → guest: view('guest.courses.show')
//                student: view('student.courses.show')
Route::get('/courses/{course:slug}', [StudentCourseController::class, 'show'])
    ->name('courses.show');

// ==============================
// AUTH (Breeze default)
// ==============================
require __DIR__ . '/auth.php';


// ==============================
// PROFILE (Breeze default)
// ==============================
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==============================
// DASHBOARD REDIRECT BY ROLE
// ==============================

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('home');
    }

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'teacher' => redirect()->route('teacher.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => redirect()->route('home'),
    };
})->middleware(['auth', 'active'])->name('dashboard');


// ==============================
// PROTECTED (auth) – ADMIN, TEACHER, STUDENT
// ==============================

Route::middleware(['auth', 'active'])->group(function () {

    // ==========================
    // ADMIN
    // ==========================
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('users', AdminUserController::class);

            // resources/views/admin/categories/*
            Route::resource('categories', AdminCategoryController::class);

            // resources/views/admin/courses/*
            Route::resource('courses', AdminCourseController::class);
        });

    // ==========================
    // TEACHER
    // ==========================
    Route::middleware('role:teacher,admin')
        ->prefix('teacher')
        ->name('teacher.')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])
                ->name('dashboard');
            // ------ COURSES ------
            // resources/views/teacher/courses/*
            Route::resource('courses', TeacherCourseController::class);

            // ------ MODULES ------
            // Route resource nested: courses/{course}/modules/...
            // View bisa di: resources/views/teacher/modules/*
            Route::resource('courses.modules', TeacherModuleController::class)
                ->shallow();
            // Nama route penting:
            // teacher.courses.modules.index   (list modul per course)
            // teacher.courses.modules.create  (form buat modul)
            // teacher.modules.edit            (edit modul) – shallow
            // Route::get('modules/{module}/lessons', [TeacherLessonController::class, 'index'])
            //     ->name('lessons.index');
    

            // ------ LESSONS ------
            // Route nested: courses/{course}/modules/{module}/lessons/...
            // View bisa di: resources/views/teacher/lessons/*
            Route::resource('courses.modules.lessons', TeacherLessonController::class)
                ->shallow();
            // ->except(['index']);
            // Nama route:
            // teacher.courses.modules.lessons.index   (list lesson per module)
            // teacher.courses.modules.lessons.create  (form buat lesson)
            // teacher.lessons.edit                    (edit lesson) – shallow
    
            // ------ CONTENTS ------
            // Route nested: courses/{course}/modules/{module}/lessons/{lesson}/contents/...
            // View bisa di: resources/views/teacher/contents/*
            Route::resource('courses.modules.lessons.contents', TeacherContentController::class)
                ->shallow();
            // Nama route:
            // teacher.courses.modules.lessons.contents.index
            // teacher.courses.modules.lessons.contents.create
            // teacher.contents.edit – shallow

        // DISKUSI KELAS (GURU)
       
            Route::post('courses/{course}/discussion', [TeacherDiscussionController::class, 'store'])
                ->name('courses.discussion.store');

            // Opsional: halaman khusus melihat diskusi course
            Route::get('courses/{course}/discussion', [TeacherDiscussionController::class, 'index'])
                ->name('courses.discussion');
         });
         Route::middleware('role:teacher')
            ->prefix('teacher')
            ->name('teacher.')
            ->group(function () {
            Route::get('private-chats', [TeacherPrivateChatController::class, 'index'])
                ->name('private-chats.index');

            // detail chat dengan 1 student
            Route::get('private-chats/{thread}', [TeacherPrivateChatController::class, 'show'])
                ->name('private-chats.show');

            // kirim pesan ke thread
            Route::post('private-chats/{thread}', [TeacherPrivateChatController::class, 'store'])
                ->name('private-chats.store');
        });

    // ==========================
    // STUDENT
    // ==========================
    Route::middleware('role:student')
        ->prefix('student')
        ->name('student.')
        ->group(function () {


            // ------ DASHBOARD STUDENT ------
            // View bisa di: resources/views/student/courses/index.blade.php
            Route::get('/', [StudentCourseController::class, 'dashboard'])
                ->name('dashboard');
            Route::middleware('course.active')->group(function () {
                // ------ DAFTAR COURSE YANG DIIKUTI ------
                // resources/views/student/courses/index.blade.php
                Route::get('courses', [StudentCourseController::class, 'index'])
                    ->name('courses.index');

                // ------ ENROLL COURSE ------
                Route::post('courses/{course}/enroll', [StudentCourseController::class, 'enroll'])
                    ->name('courses.enroll');
                // buka chat dengan guru tertentu
                Route::post('courses/{course}/discussion', [StudentDiscussionController::class, 'store'])
                    ->name('courses.discussion.store');
                // ------ HALAMAN BELAJAR ------
                // resources/views/student/courses/learn.blade.php
                Route::get('courses/{course}/learn', [StudentCourseController::class, 'learn'])
                    ->name('courses.learn');
            });
            // ------ LESSON PROGRESS ------
            Route::post('lessons/{lesson}/mark-done', [StudentLessonController::class, 'markDone'])
            ->name('lessons.mark-done');



            Route::post('courses/{course}/chat', [StudentPrivateChatController::class, 'store'])
                ->name('courses.chat.store');
            // ------ CERTIFICATE LIST ------
            // resources/views/student/certificates/index.blade.php
            // ------ CERTIFICATE LIST ------
            Route::get('certificates', [StudentCertificateController::class, 'index'])
                ->name('certificates.index');

            // DETAIL SERTIFIKAT
            Route::get('certificates/{certificate}', [StudentCertificateController::class, 'show'])
                ->name('certificates.show');

            // DOWNLOAD PDF
            Route::get('certificates/{certificate}/download', [StudentCertificateController::class, 'download'])
                ->name('certificates.download');

            // SERTIFIKAT BERDASARKAN COURSE (opsional)
            Route::get('courses/{course}/certificate', [StudentCertificateController::class, 'showByCourse'])
                ->name('courses.certificate.show');
            Route::get('contents/{content}/download', [StudentContentController::class, 'download'])
                ->name('contents.download');

            Route::get('contents/{content}/stream', [StudentContentController::class, 'stream'])
                ->name('contents.stream');

            Route::get('contents/{content}/image', [StudentContentController::class, 'image'])
                ->name('contents.image');
        });
});
