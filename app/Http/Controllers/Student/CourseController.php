<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\LessonUserProgress;
use App\Models\DiscussionMessage; 
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // DETAIL COURSE
    public function show(Course $course)
    {
        $course->load('category', 'teacher', 'modules.lessons', 'students');

        return view('courses.show', compact('course'));
    }

   
    public function catalog(Request $request)
    {
        $search     = $request->query('search', '');
        $categoryId = $request->query('category_id', '');
        $myOnly     = $request->boolean('my_only');

        $categories = Category::orderBy('name')->get();

        $query = Course::with(['teacher', 'category'])
            ->withCount('students');

        // filter search
        if ($search) {
            $q = '%' . $search . '%';
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', $q)
                    ->orWhereHas('teacher', function ($teacherQuery) use ($q) {
                        $teacherQuery->where('name', 'like', $q);
                    });
            });
        }

        // filter kategori
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // filter "kursus saya"
        if ($myOnly && auth()->check()) {
            $user = auth()->user();

            if (method_exists($user, 'isStudent') && $user->isStudent()) {
                $userId = $user->id;

                $query->whereHas('students', function ($q) use ($userId) {
                    $q->where('users.id', $userId);
                });
            }
        }

        $courses = $query->paginate(9)->withQueryString();

        return view('courses.catalog', [
            'courses'     => $courses,
            'categories'  => $categories,
            'search'      => $search,
            'categoryId'  => $categoryId,
            'myOnly'      => $myOnly,
        ]);
    }

    // DASHBOARD STUDENT
    public function dashboard(Request $request)
    {
        $user = $request->user();

        $enrolledQuery = $user->enrolledCourses()
            ->with(['category', 'teacher', 'modules.lessons']);

        $enrolledCount = (clone $enrolledQuery)->count();

        $completedCount = (clone $enrolledQuery)
            ->wherePivot('is_completed', true)
            ->count();

        $certCount = $user->certificates()->count();

        $recentCourses = (clone $enrolledQuery)
            ->orderByDesc('course_student.updated_at')
            ->take(3)
            ->get()
            ->map(function ($course) use ($user) {
                $lessonIds = $course->modules
                    ->flatMap(fn ($m) => $m->lessons)
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
            'enrolledCount'  => $enrolledCount,
            'completedCount' => $completedCount,
            'certCount'      => $certCount,
            'recentCourses'  => $recentCourses,
        ]);
    }

    // ENROLL COURSE
    public function enroll(Course $course)
    {
        $user = auth()->user();

        $user->enrolledCourses()->syncWithoutDetaching([
            $course->id => [
                'enrolled_at' => now(),
            ],
        ]);

        return redirect()->route('student.courses.learn', ['course' => $course->id])
            ->with('success', 'Berhasil mendaftar course.');
    }

    // LIST COURSE YANG DIAMBIL STUDENT
    public function index(Request $request)
    {
        $user = $request->user();

        if (method_exists($user, 'enrolledCourses')) {
            $courses = $user->enrolledCourses()
                ->with(['category', 'modules.lessons'])
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

            $course->is_completed = (bool) ($course->pivot->is_completed ?? false);
        }

        return view('student.courses.index', [
            'courses' => $courses,
        ]);
    }

  
    public function learn(Request $request, Course $course)
    {
        $user = $request->user();

        // Pastikan user sudah enroll
        if (
            ! method_exists($user, 'enrolledCourses') ||
            ! $user->enrolledCourses()->where('course_id', $course->id)->exists()
        ) {
            abort(403);
        }

        // Load modul + lesson + contents dengan urutan
        $course->load([
            'modules' => function ($q) {
                $q->orderBy('order');
            },
            'modules.lessons' => function ($q) {
                $q->orderBy('order')->with('contents');
            },
        ]);

        // ⬇ AMBIL SEMUA DISKUSI UNTUK COURSE INI
        $discussions = DiscussionMessage::where('course_id', $course->id)
            ->with('user')
            ->orderBy('created_at')
            ->get();

        // Kumpulkan semua lesson dalam satu list linear
        $allLessons = $course->modules
            ->flatMap(fn ($m) => $m->lessons)
            ->values();

        // Kalau belum ada lesson sama sekali
        if ($allLessons->isEmpty()) {
            return view('student.courses.learn', [
                'course'           => $course,
                'currentLesson'    => null,
                'doneLessonIds'    => [],
                'allowedLessonIds' => [],
                'discussions'      => $discussions, 
            ]);
        }

        // Semua lesson_id
        $lessonIds = $allLessons->pluck('id')->values();

        // Lesson yang SUDAH selesai oleh user ini
        $doneLessonIds = LessonUserProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $lessonIds)
            ->where('is_done', true)
            ->pluck('lesson_id')
            ->toArray();

        // Lesson yang diminta dari query ?lesson=
        $requestedLessonId = $request->query('lesson');
        $currentLesson = null;

        if ($requestedLessonId && $lessonIds->contains((int) $requestedLessonId)) {
            $currentLesson = $allLessons->firstWhere('id', (int) $requestedLessonId);
        }

        // Fallback:
        // - pakai lesson pertama yang belum selesai
        // - kalau semua sudah selesai → pakai lesson pertama
        if (! $currentLesson) {
            $firstNotDone = $allLessons->first(function ($l) use ($doneLessonIds) {
                return ! in_array($l->id, $doneLessonIds);
            });

            $currentLesson = $firstNotDone ?: $allLessons->first();
        }
        
        // TENTUKAN LESSON YANG BOLEH DIAKSES
        $allowedLessonIds = [];
        $firstLockedFound = false;

        foreach ($allLessons as $lesson) {
            if (in_array($lesson->id, $doneLessonIds)) {
                // Lesson yang sudah selesai → boleh diakses ulang
                $allowedLessonIds[] = $lesson->id;
                continue;
            }

            if (! $firstLockedFound) {
                // Lesson pertama yang belum selesai → boleh diakses (target berikut)
                $allowedLessonIds[] = $lesson->id;
                $firstLockedFound = true;
            }
            // Lesson setelahnya tidak dimasukkan → terkunci
        }

        // Kalau user coba akses lesson yang belum diizinkan → paksa ke lesson pertama yang boleh
        if (! in_array($currentLesson->id, $allowedLessonIds) && ! empty($allowedLessonIds)) {
            $currentLesson = $allLessons->firstWhere('id', $allowedLessonIds[0]);
        }

        return view('student.courses.learn', [
            'course'           => $course,
            'currentLesson'    => $currentLesson,
            'doneLessonIds'    => $doneLessonIds,
            'allowedLessonIds' => $allowedLessonIds,
            'discussions'      => $discussions, // ⬅️ dikirim ke view
        ]);
    }
}
