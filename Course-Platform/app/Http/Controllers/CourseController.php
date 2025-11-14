<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // ========= PUBLIC =========
    public function publicIndex()
    {
        $courses = Course::active()
            ->with(['teacher','category'])
            ->withCount('students')
            ->paginate(9);

        return view('courses.public-index', compact('courses'));
    }

    public function publicShow(Course $course)
    {
        $course->load(['teacher','category','contents']);
        return view('courses.public-show', compact('course'));
    }

    // ========= ADMIN/TEACHER =========
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $courses = Course::with(['teacher','category'])->paginate(15);
        } else {
            // teacher: hanya course yang dia ajar
            $courses = Course::where('teacher_id', $user->id)
                ->with('category')
                ->paginate(15);
        }

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $teachers = User::where('role', User::ROLE_TEACHER)->get();

        return view('courses.create', compact('categories','teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'teacher_id'  => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'status'      => 'required|in:active,inactive',
        ]);

        $user = Auth::user();

        // jika teacher, paksa teacher_id = dirinya sendiri
        if ($user->isTeacher()) {
            $request->merge(['teacher_id' => $user->id]);
        }

        Course::create($request->all());

        return redirect()->route('courses.manage.index')
            ->with('status', 'Course berhasil dibuat');
    }

    public function edit(Course $course)
    {
        $this->authorizeCourse($course);

        $categories = Category::orderBy('name')->get();
        $teachers   = User::where('role', User::ROLE_TEACHER)->get();

        return view('courses.edit', compact('course','categories','teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeCourse($course);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'teacher_id'  => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'status'      => 'required|in:active,inactive',
        ]);

        $user = Auth::user();
        if ($user->isTeacher()) {
            $request->merge(['teacher_id' => $user->id]);
        }

        $course->update($request->all());

        return redirect()->route('courses.manage.index')
            ->with('status', 'Course berhasil diupdate');
    }

    public function destroy(Course $course)
    {
        $this->authorizeCourse($course);
        $course->delete();

        return redirect()->route('courses.manage.index')
            ->with('status', 'Course berhasil dihapus');
    }

    private function authorizeCourse(Course $course): void
    {
        $user = Auth::user();

        // Admin boleh apa saja, teacher hanya course miliknya
        if ($user->isAdmin()) return;

        if ($user->isTeacher() && $course->teacher_id == $user->id) return;

        abort(403, 'Anda tidak boleh mengelola course ini.');
    }
}
