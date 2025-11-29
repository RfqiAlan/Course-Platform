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
    /**
     * List course + filter search, kategori, status.
     * View  : resources/views/admin/courses/index.blade.php
     * Route : admin.courses.index
     */
    public function index(Request $request)
    {
        // ambil parameter dari form (name="search", "category", "status")
        $search     = $request->input('search');
        $categoryId = $request->input('category');
        $status     = $request->input('status'); // 'active' / 'inactive' / null

        $query = Course::with(['teacher', 'category'])
            ->latest();

        // FILTER: search judul / nama teacher
        if ($search) {
            $q = '%' . $search . '%';

            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', $q)
                    ->orWhereHas('teacher', function ($teacherQuery) use ($q) {
                        $teacherQuery->where('name', 'like', $q);
                    });
            });
        }

        // FILTER: kategori
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // FILTER: status aktif / nonaktif
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $courses = $query->paginate(10)->withQueryString();

        // untuk dropdown filter kategori di Blade
        $categories = Category::orderBy('name')->get();

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $teachers   = User::where('role', 'teacher')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('admin.courses.create', compact('teachers', 'categories'));
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

        $data['slug']      = Str::slug($data['title']) . '-' . Str::random(4);
        $data['is_active'] = $request->has('is_active');

        Course::create($data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course berhasil dibuat.');
    }

    public function edit(Course $course)
    {
        $teachers = User::where('role', 'teacher')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'teachers', 'categories'));
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

        // regenerate slug kalau judul berubah
        if ($data['title'] !== $course->title) {
            $data['slug'] = Str::slug($data['title']) . '-' . Str::random(4);
        }

        $data['is_active'] = $request->has('is_active');

        $course->update($data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course berhasil diupdate.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }
}
