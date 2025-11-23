<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\LessonUserProgress;

class CourseController extends Controller
{
    // detail course untuk student (kalau kamu tidak pakai controller public terpisah)
    public function show(Course $course)
    {
        $course->load('category', 'teacher', 'modules.lessons', 'students');

        return view('courses.show', compact('course'));
    }

    // tambahkan use di atas kalau belum

    public function dashboard(Request $request)
    {
        $user = $request->user();

        // === Query course yang di-enroll student ini ===
        $enrolledQuery = $user->enrolledCourses()
            ->with(['category', 'teacher', 'modules.lessons']); // penting untuk hitung progress

        // 1) Jumlah course diikuti
        $enrolledCount = (clone $enrolledQuery)->count();

        // 2) Jumlah course selesai (pakai pivot is_completed)
        $completedCount = (clone $enrolledQuery)
            ->wherePivot('is_completed', true)
            ->count();

        // 3) Jumlah sertifikat
        $certCount = $user->certificates()->count();

        // 4) Ambil beberapa course terakhir + hitung progress
        $recentCourses = (clone $enrolledQuery)
            ->orderByDesc('course_student.updated_at')
            ->take(3)
            ->get()
            ->map(function ($course) use ($user) {
                // kumpulkan semua lesson di course ini
                $lessonIds = $course->modules
                    ->flatMap(fn($m) => $m->lessons)
                    ->pluck('id');

                $totalLessons = $lessonIds->count();

                if ($totalLessons > 0) {
                    $done = LessonUserProgress::where('user_id', $user->id)
                        ->whereIn('lesson_id', $lessonIds)
                        ->where('is_done', true)
                        ->count();

                    $course->progress_percent = (int) round($done / $totalLessons * 100);
                } else {
                    $course->progress_percent = 0;
                }

                return $course;
            });

        return view('student.dashboard', [
            'enrolledCount' => $enrolledCount,
            'completedCount' => $completedCount,
            'certCount' => $certCount,
            'recentCourses' => $recentCourses,
        ]);
    }

    public function enroll(Course $course)
    {
        $user = auth()->user();

        $user->enrolledCourses()->syncWithoutDetaching([
            $course->id => [
                'enrolled_at' => now(),
            ],
        ]);

        return redirect()->route('student.courses.learn', $course)
            ->with('success', 'Berhasil mendaftar course.');
    }
    public function index(Request $request)
    {
        $user = $request->user();

        if (method_exists($user, 'enrolledCourses')) {
            $courses = $user->enrolledCourses()
                ->with(['category', 'modules.lessons'])   // load category + semua modul & lesson
                ->latest()
                ->get();
        } else {
            $courses = Course::whereHas('students', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
                ->with(['category', 'modules.lessons'])
                ->latest()
                ->get();
        }

        // Hitung progress untuk tiap course
        foreach ($courses as $course) {
            $lessonIds = $course->modules
                ->flatMap(fn($m) => $m->lessons)
                ->pluck('id')
                ->values();

            $totalLessons = $lessonIds->count();

            if ($totalLessons > 0) {
                $doneLessons = LessonUserProgress::where('user_id', $user->id)
                    ->whereIn('lesson_id', $lessonIds)
                    ->where('is_done', true)
                    ->count();

                $course->progress_percent = (int) round($doneLessons / $totalLessons * 100);
            } else {
                $course->progress_percent = 0;
            }

            // Biar gampang dipakai di Blade:
            $course->is_completed = (bool) ($course->pivot->is_completed ?? false);
        }

        return view('student.courses.index', [
            'courses' => $courses,
        ]);
    }


    public function learn(Request $request, Course $course)
    {
        $user = auth()->user();

        // pastikan user sudah enroll course ini
        abort_unless($user->enrolledCourses->contains($course->id), 403);

        // load modul + lesson + contents
        $course->load('modules.lessons.contents');

        // kumpulkan semua lesson dalam course ini
        $allLessons = $course->modules
            ->flatMap(fn($m) => $m->lessons)
            ->values();

        $lessonIds = $allLessons->pluck('id')->values();

        // ambil id lesson yang SUDAH SELESAI untuk user ini
        $doneLessonIds = LessonUserProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $lessonIds)
            ->where('is_done', true)
            ->pluck('lesson_id')
            ->toArray();

        // pilih lesson aktif dari query ?lesson=
        $currentLesson = null;
        if ($lessonId = $request->query('lesson')) {
            $currentLesson = $allLessons->firstWhere('id', (int) $lessonId);
        }

        // fallback: kalau tidak ada / id tidak cocok → pakai lesson pertama
        if (!$currentLesson) {
            $currentLesson = $allLessons->first();
        }

        return view('student.courses.learn', [
            'course' => $course,
            'currentLesson' => $currentLesson,
            'doneLessonIds' => $doneLessonIds,
        ]);
    }


}
