<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;

// =====================
// Public Routes
// =====================

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Katalog course (bisa diakses guest & user login)
Route::get('/courses', [CourseController::class, 'publicIndex'])
    ->name('courses.public.index');

Route::get('/courses/{course}', [CourseController::class, 'publicShow'])
    ->name('courses.public.show');

// Route auth dari Breeze (login, register, reset password)
require __DIR__ . '/auth.php';


// =====================
// Protected Routes (auth + verified)
// =====================
Route::middleware(['auth', 'verified'])->group(function () {
    // ===== PROFILE (Breeze default) =====
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    // Dashboard (isi-nya beda sesuai role di HomeController@dashboard)
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');


    // ---------- ADMIN ONLY ----------
    Route::middleware('role:admin')->group(function () {

        // CRUD User
        Route::resource('users', AdminUserController::class);

        // CRUD Kategori
        Route::resource('categories', CategoryController::class);
    });


    // ---------- ADMIN + TEACHER : manage course & content ----------
    // ---------- ADMIN + TEACHER : manage course & content ----------
Route::middleware('role:admin,teacher')
    ->prefix('manage')
    ->group(function () {

        // URL: /manage/courses
        // Name: courses.manage.index, courses.manage.create, dst
        Route::resource('courses', CourseController::class)
            ->except(['show'])
            ->names([
                'index'   => 'courses.manage.index',
                'create'  => 'courses.manage.create',
                'store'   => 'courses.manage.store',
                'edit'    => 'courses.manage.edit',
                'update'  => 'courses.manage.update',
                'destroy' => 'courses.manage.destroy',
            ]);

        // URL: /manage/contents
        // Name: contents.index, contents.create, dst
        Route::resource('contents', ContentController::class)
            ->names([
                'index'   => 'contents.index',
                'create'  => 'contents.create',
                'store'   => 'contents.store',
                'show'    => 'contents.show',
                'edit'    => 'contents.edit',
                'update'  => 'contents.update',
                'destroy' => 'contents.destroy',
            ]);
    });


    // ---------- STUDENT ONLY ----------
    Route::middleware('role:student')->group(function () {

        // Daftar / enroll ke course
        Route::post('/courses/{course}/enroll', [LessonController::class, 'enroll'])
            ->name('courses.enroll');

        // Baca materi / lesson
        Route::get('/courses/{course}/lessons/{content}', [LessonController::class, 'show'])
            ->name('lessons.show');

        // Tandai materi selesai
        Route::post('/lessons/{content}/mark-done', [LessonController::class, 'markDone'])
            ->name('lessons.mark-done');
    });
});
