<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

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

        // --- Pilihan 1: kalau kamu punya relasi khusus di User, misalnya:
        // public function enrolledCourses() { return $this->belongsToMany(Course::class, 'course_student'); }
        if (method_exists($user, 'enrolledCourses')) {
            $courses = $user->enrolledCourses()
                ->with('category')   // kalau ada relasi
                ->latest()
                ->get();
        } else {
            // --- Pilihan 2: fallback pakai pivot course_student ---
            $courses = Course::whereHas('students', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with('category')
                ->latest()
                ->get();
        }

        return view('student.courses.index', [
            'courses' => $courses,
        ]);
    }

    public function learn(Request $request, Course $course)
    {
        $user = auth()->user();

        abort_unless($user->enrolledCourses->contains($course->id), 403);

        $course->load('modules.lessons.contents');

        // optional: pilih lesson aktif dari query ?lesson=
        $currentLesson = null;
    if ($lessonId = $request->query('lesson')) {
        $currentLesson = Lesson::where('id', $lessonId)
            ->whereHas('module', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })
            ->first();
        }

        return view('student.courses.learn', compact('course','currentLesson'));
    }
}
