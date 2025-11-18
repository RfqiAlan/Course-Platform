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
        $course->load('category','teacher','modules.lessons','students');

        return view('courses.show', compact('course'));
    }
    public function dashboard()
  {
    return view('student.dashboard');
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
            ->flatMap(fn ($m) => $m->lessons)
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
        ->flatMap(fn ($m) => $m->lessons)
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
    if (! $currentLesson) {
        $currentLesson = $allLessons->first();
    }

    return view('student.courses.learn', [
        'course'        => $course,
        'currentLesson' => $currentLesson,
        'doneLessonIds' => $doneLessonIds,
    ]);
}


}
