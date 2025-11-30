<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Module;
use App\Models\DiscussionMessage; // ⬅️ penting: untuk ambil diskusi
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $courses = Course::with(['category', 'modules.lessons'])
            ->where('teacher_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('teacher.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['teacher_id'] = $request->user()->id;
        $data['slug'] = \Str::slug($data['title']) . '-' . uniqid();
        $data['is_active'] = $request->boolean('is_active', true);

        Course::create($data);

        return redirect()->route('teacher.courses.index')
            ->with('success', 'Course berhasil dibuat.');
    }

    public function show(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        $course->load([
            'category',
            'modules.lessons' => function ($q) {
                $q->orderBy('order');
            },
            'students',
        ]);

        $discussions = DiscussionMessage::where('course_id', $course->id)
            ->with('user')
            ->orderBy('created_at')
            ->get();

        return view('teacher.courses.show', [
            'course'      => $course,
            'discussions' => $discussions, // ⬅️ kirim ke view
        ]);
    }

    public function edit(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::orderBy('name')->get();

        return view('teacher.courses.edit', [
            'course'     => $course,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $course->update($data);

        return redirect()->route('teacher.courses.index')
            ->with('success', 'Course berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        $course->delete();

        return redirect()->route('teacher.courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }
}
