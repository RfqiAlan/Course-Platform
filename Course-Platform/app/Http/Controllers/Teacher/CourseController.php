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
    // LIST COURSE MILIK TEACHER
    public function index(Request $request)
    {
        $user = $request->user();

        $courses = Course::with(['category', 'modules.lessons'])
            ->where('teacher_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('teacher.courses.index', compact('courses'));
    }

    // FORM BUAT COURSE
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('teacher.courses.create', compact('categories'));
    }

    // SIMPAN COURSE BARU
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

    // DETAIL COURSE (UNTUK TEACHER)
    public function show(Course $course)
    {
        // Pastikan course ini milik teacher yang login
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        // Load relasi untuk tampilan
        $course->load([
            'category',
            'modules.lessons' => function ($q) {
                $q->orderBy('order');
            },
            'students',
        ]);

        // ⬇️ AMBIL SEMUA DISKUSI UNTUK COURSE INI
        $discussions = DiscussionMessage::where('course_id', $course->id)
            ->with('user')
            ->orderBy('created_at')
            ->get();

        return view('teacher.courses.show', [
            'course'      => $course,
            'discussions' => $discussions, // ⬅️ kirim ke view
        ]);
    }

    // FORM EDIT COURSE
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

    // UPDATE COURSE
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

    // HAPUS COURSE
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
