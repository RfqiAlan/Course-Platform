<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['teacher','category'])
            ->latest()
            ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $teachers   = User::where('role', 'teacher')->where('is_active', true)->get();
        $categories = Category::all();

        return view('admin.courses.create', compact('teachers','categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'teacher_id'  => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(4);
        $data['is_active'] = $data['is_active'] ?? true;

        Course::create($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil dibuat.');
    }

    public function edit(Course $course)
    {
        $teachers   = User::where('role', 'teacher')->where('is_active', true)->get();
        $categories = Category::all();

        return view('admin.courses.edit', compact('course','teachers','categories'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'teacher_id'  => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'is_active'   => 'nullable|boolean',
        ]);

        if ($data['title'] !== $course->title) {
            $data['slug'] = Str::slug($data['title']) . '-' . Str::random(4);
        }

        $data['is_active'] = $data['is_active'] ?? false;

        $course->update($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil diupdate.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }
}
