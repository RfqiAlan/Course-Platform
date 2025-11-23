<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->taughtCourses()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('teacher.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'preview_video' => 'nullable|file|mimetypes:video/mp4,video/x-m4v,video/quicktime|max:51200', // max 50MB
            'is_active'    => 'nullable|boolean',
        ]);

        $data['teacher_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(4);
         $data['is_active']  = $request->has('is_active');
        if ($request->hasFile('preview_video')) {
            $data['preview_video'] = $request->file('preview_video')
                ->store('course_previews', 'public');
        }
        Course::create($data);

        return redirect()->route('teacher.courses.index')
            ->with('success', 'Course berhasil dibuat.');
    }

    public function edit(Course $course)
    {
        $this->authorizeOwnership($course);

        $categories = Category::all();

        return view('teacher.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeOwnership($course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'preview_video' => 'nullable|file|mimetypes:video/mp4,video/x-m4v,video/quicktime|max:51200',
            'is_active'    => 'nullable|boolean',
        ]);

        if ($data['title'] !== $course->title) {
            $data['slug'] = Str::slug($data['title']) . '-' . Str::random(4);
        }

         $data['is_active'] = $request->has('is_active');

        $course->update($data);

        return redirect()->route('teacher.courses.index')
            ->with('success', 'Course berhasil diupdate.');
    }

    public function destroy(Course $course)
    {
        $this->authorizeOwnership($course);

        $course->delete();

        return redirect()->route('teacher.courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }
    public function show(Course $course)
    {
        $this->authorizeOwnership($course);

        // load relasi yang dibutuhkan di view (opsional)
        $course->load(['category', 'modules.lessons']);

        return view('teacher.courses.show', compact('course'));
    }


    protected function authorizeOwnership(Course $course): void
    {
        abort_unless($course->teacher_id === auth()->id(), 403);
    }
}
