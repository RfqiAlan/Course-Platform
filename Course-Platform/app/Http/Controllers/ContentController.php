<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $contents = Content::with('course')->paginate(20);
        } else {
            $contents = Content::where('teacher_id', $user->id)
                ->with('course')
                ->paginate(20);
        }

        return view('contents.index', compact('contents'));
    }

    public function create()
    {
        $user = Auth::user();

        $courses = $user->isAdmin()
            ? Course::all()
            : Course::where('teacher_id', $user->id)->get();

        return view('contents.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title'     => 'required|string|max:255',
            'body'      => 'required|string',
            'order'     => 'nullable|integer|min:1',
        ]);

        $user = Auth::user();

        $course = Course::findOrFail($request->course_id);
        if ($user->isTeacher() && $course->teacher_id != $user->id) {
            abort(403);
        }

        Content::create([
            'course_id' => $course->id,
            'title'     => $request->title,
            'body'      => $request->body,
            'order'     => $request->order ?? 1,
            'teacher_id'=> $user->isAdmin() ? $course->teacher_id : $user->id,
        ]);

        return redirect()->route('contents.index')
            ->with('status','Materi berhasil dibuat');
    }

    public function edit(Content $content)
    {
        $this->authorizeContent($content);

        $user = Auth::user();
        $courses = $user->isAdmin()
            ? Course::all()
            : Course::where('teacher_id', $user->id)->get();

        return view('contents.edit', compact('content','courses'));
    }

    public function update(Request $request, Content $content)
    {
        $this->authorizeContent($content);

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title'     => 'required|string|max:255',
            'body'      => 'required|string',
            'order'     => 'nullable|integer|min:1',
        ]);

        $content->update($request->all());

        return redirect()->route('contents.index')
            ->with('status','Materi berhasil diupdate');
    }

    public function destroy(Content $content)
    {
        $this->authorizeContent($content);
        $content->delete();

        return back()->with('status','Materi berhasil dihapus');
    }

    private function authorizeContent(Content $content): void
    {
        $user = Auth::user();
        if ($user->isAdmin()) return;
        if ($user->isTeacher() && $content->teacher_id == $user->id) return;

        abort(403);
    }
}
