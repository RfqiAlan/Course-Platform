<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * List semua lesson dalam satu module (nested).
     * Route: teacher.courses.modules.lessons.index
     * URL  : /teacher/courses/{course}/modules/{module}/lessons
     */
    public function index(Course $course, Module $module)
    {
        // Boleh diaktifkan kalau mau ketat:
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);

        $lessons = $module->lessons()->orderBy('order')->get();

        return view('teacher.lessons.index', compact('course', 'module', 'lessons'));
    }

    /**
     * Form tambah lesson (nested).
     * Route: teacher.courses.modules.lessons.create
     */
    public function create(Course $course, Module $module)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);

        return view('teacher.lessons.create', compact('course', 'module'));
    }

    /**
     * Simpan lesson baru (nested).
     * Route: teacher.courses.modules.lessons.store
     */
    public function store(Request $request, Course $course, Module $module)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);

        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'summary' => 'nullable|string',
            'order'   => 'nullable|integer',
        ]);

        // kalau order kosong, auto di-set max+1
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

    /**
     * Detail 1 lesson (shallow).
     * Route: teacher.lessons.show
     * URL  : /teacher/lessons/{lesson}
     */
    public function show(Lesson $lesson)
    {
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        return view('teacher.lessons.show', compact('course', 'module', 'lesson'));
    }

    /**
     * Form edit lesson (shallow).
     * Route: teacher.lessons.edit
     * URL  : /teacher/lessons/{lesson}/edit
     */
    public function edit(Lesson $lesson)
    {
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        return view('teacher.lessons.edit', compact('course', 'module', 'lesson'));
    }

    /**
     * Update lesson (shallow).
     * Route: teacher.lessons.update
     * URL  : /teacher/lessons/{lesson}
     */
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

    /**
     * Hapus lesson (shallow).
     * Route: teacher.lessons.destroy
     * URL  : /teacher/lessons/{lesson}
     */
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

    /**
     * Hanya teacher pemilik course yang boleh akses.
     */
    protected function authorizeCourse(Course $course): void
    {
        abort_unless($course->teacher_id === auth()->id(), 403);
    }
}
