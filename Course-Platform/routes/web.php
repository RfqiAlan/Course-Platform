<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==============================
// Livewire (Public Pages)
// ==============================
use App\Livewire\Homepage;
use App\Livewire\CourseCatalog;

// Breeze Profile
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
use App\Http\Controllers\Teacher\QuizController as TeacherQuizController;
use App\Http\Controllers\Teacher\QuizQuestionController as TeacherQuizQuestionController;

// Student Controllers
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;

// ==============================
// PUBLIC / GUEST
// ==============================
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/test-pdf', function () {
    $data = [
        'name' => 'Tes PDF',
        'course' => 'Laravel Course',
        'date' => now()->format('d F Y'),
    ];

    $pdf = Pdf::loadView('test-pdf', $data);

    return $pdf->download('test.pdf');
});

// Beranda (Livewire page)
Route::get('/', Homepage::class)->name('home');

// Katalog course (Livewire page)
Route::get('/courses', CourseCatalog::class)->name('courses.index');

// Detail course publik (pakai slug, ditangani StudentCourseController@show)
Route::get('/courses/{course:slug}', [StudentCourseController::class, 'show'])
    ->name('courses.show');

// ==============================
// AUTH (Breeze default)
// ==============================
require __DIR__ . '/auth.php';

// ==============================
// PROFILE (Breeze default)
// ==============================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================
// DASHBOARD (Breeze redirect by role)
// ==============================

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (! $user) {
        return redirect()->route('home');
    }

    // Routing berdasarkan role
    if ($user->role === 'admin') {
        return redirect()->route('admin.courses.index');
    }

    if ($user->role === 'teacher') {
        return redirect()->route('teacher.courses.index');
    }

    if ($user->role === 'student') {
        return redirect()->route('student.dashboard');
    }

    // fallback kalau role tidak dikenali
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// ==============================
// PROTECTED (auth) – ADMIN, TEACHER, STUDENT
// ==============================

Route::middleware(['auth'])->group(function () {

    // ==========================
    // ADMIN
    // ==========================
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // resources/views/admin/users/*
            Route::resource('users', AdminUserController::class);

            // resources/views/admin/categories/*
            Route::resource('categories', AdminCategoryController::class);

            // resources/views/admin/courses/*
            Route::resource('courses', AdminCourseController::class);
        });

    // ==========================
    // TEACHER
    // ==========================
    Route::middleware('role:teacher')
        ->prefix('teacher')
        ->name('teacher.')
        ->group(function () {
            Route::get('ping', function () {
            return 'OK TEACHER';
            })->name('ping');

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

            // ------ QUIZZES ------
            // resources/views/teacher/quizzes/*
            Route::resource('quizzes', TeacherQuizController::class);

            // ------ QUIZ QUESTIONS ------
            // resources/views/teacher/quizzes/questions/*
            Route::prefix('quizzes/{quiz}')->group(function () {
                Route::get('questions',        [TeacherQuizQuestionController::class, 'index'])
                    ->name('quizzes.questions.index');

                Route::get('questions/create', [TeacherQuizQuestionController::class, 'create'])
                    ->name('quizzes.questions.create');

                Route::post('questions',       [TeacherQuizQuestionController::class, 'store'])
                    ->name('quizzes.questions.store');
            });

            Route::get('questions/{question}/edit', [TeacherQuizQuestionController::class, 'edit'])
                ->name('quizzes.questions.edit');

            Route::put('questions/{question}', [TeacherQuizQuestionController::class, 'update'])
                ->name('quizzes.questions.update');

            Route::delete('questions/{question}', [TeacherQuizQuestionController::class, 'destroy'])
                ->name('quizzes.questions.destroy');
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

            // ------ DAFTAR COURSE YANG DIIKUTI ------
            // resources/views/student/courses/index.blade.php
            Route::get('courses', [StudentCourseController::class, 'index'])
                ->name('courses.index');

            // ------ ENROLL COURSE ------
            Route::post('courses/{course}/enroll', [StudentCourseController::class, 'enroll'])
                ->name('courses.enroll');

            // ------ HALAMAN BELAJAR ------
            // resources/views/student/courses/learn.blade.php
            Route::get('courses/{course}/learn', [StudentCourseController::class, 'learn'])
                ->name('courses.learn');

            // ------ LESSON PROGRESS ------
            Route::post('lessons/{lesson}/mark-done', [LessonController::class, 'markDone'])
                ->name('lessons.mark-done');

            // ------ SUBMIT QUIZ (non-Livewire) ------
            Route::post('quizzes/{quiz}/submit', [QuizController::class, 'submit'])
                ->name('quizzes.submit');

            // ------ CERTIFICATE LIST ------
            // resources/views/student/certificates/index.blade.php
            Route::get('certificates', [CertificateController::class, 'index'])
                ->name('certificates.index');

            Route::get('courses/{course}/certificate', [CertificateController::class, 'show'])
            ->name('courses.certificate.show');
            // ------ CERTIFICATE DETAIL / PDF ------
            // resources/views/student/certificates/show.blade.php atau PDF
            Route::get('certificates/{certificate}', [CertificateController::class, 'show'])
                ->name('certificates.show');

            // ------ CERTIFICATE BY COURSE (opsional) ------
            Route::get('courses/{course}/certificate', [CertificateController::class, 'showByCourse'])
                ->name('courses.certificate');
        });
});
