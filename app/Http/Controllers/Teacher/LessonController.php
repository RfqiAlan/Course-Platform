<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;

class LessonController extends Controller
{
  
    public function index(Course $course, Module $module)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);

        $lessons = $module->lessons()
            ->orderBy('order')
            ->get();

        return view('teacher.lessons.index', compact('course', 'module', 'lessons'));
    }


    public function create(Course $course, Module $module)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);

        return view('teacher.lessons.create', compact('course', 'module'));
    }


    public function store(Request $request, Course $course, Module $module)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);

        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'summary' => 'nullable|string',
            'order'   => 'nullable|integer',
        ]);

        if (! isset($data['order']) || $data['order'] === '' || $data['order'] === null) {
            $maxOrder = $module->lessons()->max('order'); // bisa null
            $data['order'] = ($maxOrder ?? 0) + 1;
        }

        $data['module_id'] = $module->id;

        Lesson::create($data);

        return redirect()
            ->route('teacher.courses.modules.lessons.index', [
                'course' => $course->id,
                'module' => $module->id,
            ])
            ->with('success', 'Lesson berhasil dibuat.');
    }

    public function show(Lesson $lesson)
    {
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        return view('teacher.lessons.show', compact('course', 'module', 'lesson'));
    }

    public function edit(Lesson $lesson)
    {
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        return view('teacher.lessons.edit', compact('course', 'module', 'lesson'));
    }
    public function update(Request $request, Lesson $lesson)
    {
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'summary' => 'nullable|string',
            'order'   => 'nullable|integer',
        ]);

        $lesson->update($data);

        return redirect()
            ->route('teacher.courses.modules.lessons.index', [
                'course' => $course->id,
                'module' => $module->id,
            ])
            ->with('success', 'Lesson berhasil diupdate.');
    }


    public function destroy(Lesson $lesson)
    {
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        $lesson->delete();

        return redirect()
            ->route('teacher.courses.modules.lessons.index', [
                'course' => $course->id,
                'module' => $module->id,
            ])
            ->with('success', 'Lesson berhasil dihapus.');
    }


    protected function authorizeCourse(Course $course): void
    {
        $user = auth()->user();

        // Admin boleh semua course
        if ($user->role === 'admin') {
            return;
        }

        // Teacher hanya course miliknya
        if ($user->role === 'teacher' && $course->teacher_id === $user->id) {
            return;
        }

        abort(403);
    }
}
