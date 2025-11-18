<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(Course $course)
    {
        $this->authorizeCourse($course);

        $modules = $course->modules()->orderBy('order')->get();

        return view('teacher.modules.index', compact('course', 'modules'));
    }

    public function create(Course $course)
    {
        $this->authorizeCourse($course);

        return view('teacher.modules.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $this->authorizeCourse($course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data['course_id'] = $course->id;

        Module::create($data);

        return redirect()
            ->route('teacher.courses.modules.index', $course)
            ->with('success', 'Modul berhasil dibuat.');
    }

    // =========================
    // SHALLOW ROUTES
    // =========================

    public function edit(Module $module)
    {
        $course = $module->course;           // ambil course dari module
        $this->authorizeCourse($course);

        return view('teacher.modules.edit', compact('course', 'module'));
    }

    public function update(Request $request, Module $module)
    {
        $course = $module->course;
        $this->authorizeCourse($course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $module->update($data);

        return redirect()
            ->route('teacher.courses.modules.index', $course)
            ->with('success', 'Modul berhasil diupdate.');
    }

    public function destroy(Module $module)
    {
        $course = $module->course;
        $this->authorizeCourse($course);

        $module->delete();

        return redirect()
            ->route('teacher.courses.modules.index', $course)
            ->with('success', 'Modul berhasil dihapus.');
    }

    protected function authorizeCourse(Course $course): void
    {
        abort_unless($course->teacher_id === auth()->id(), 403);
    }
}
