<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{

    public function index(Course $course, Module $module, Lesson $lesson)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);
        abort_unless($lesson->module_id === $module->id, 404);

        $contents = $lesson->contents()->orderBy('order')->get();

        return view('teacher.contents.index', compact('course', 'module', 'lesson', 'contents'));
    }


    public function create(Course $course, Module $module, Lesson $lesson)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);
        abort_unless($lesson->module_id === $module->id, 404);

        $nextOrder = ($lesson->contents()->max('order') ?? 0) + 1;

        return view('teacher.contents.create', [
            'course'    => $course,
            'module'    => $module,
            'lesson'    => $lesson,
            'nextOrder' => $nextOrder,
        ]);
    }


    public function store(Request $request, Course $course, Module $module, Lesson $lesson)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);
        abort_unless($lesson->module_id === $module->id, 404);


        $data = $request->validate([
            'type'  => 'required|in:text,file,video', // enum di DB masih text|file|video
            'title' => 'nullable|string|max:255',
            'body'  => 'nullable|string',
            'file'  => 'nullable|file',
            'video' => 'nullable|file',
            'order' => 'nullable|integer',
        ]);

        if ($request->type === 'text') {
            $request->validate([
                'body' => 'required|string',
            ]);
        }

        if ($request->type === 'file') {
            $request->validate([
                'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png,webp|max:51200',
            ]);
        }

        if ($request->type === 'video') {
            $request->validate([
                'video' => 'required|file|mimetypes:video/mp4,video/quicktime|max:204800',
            ]);
        }

        if (!isset($data['order']) || $data['order'] === '' || $data['order'] === null) {
            $maxOrder      = $lesson->contents()->max('order');
            $data['order'] = ($maxOrder ?? 0) + 1;
        }

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('course/files', 'public');
        } else {
            $data['file_path'] = null;
        }

        if ($request->hasFile('video')) {
            $data['video_path'] = $request->file('video')->store('course/videos', 'public');
        } else {
            $data['video_path'] = null;
        }

        $data['lesson_id'] = $lesson->id;

        unset($data['file'], $data['video']);

        Content::create($data);

        return redirect()
            ->route('teacher.courses.modules.lessons.contents.index', [
                'course' => $course->id,
                'module' => $module->id,
                'lesson' => $lesson->id,
            ])
            ->with('success', 'Materi berhasil dibuat.');
    }


    public function edit(Content $content)
    {
        $lesson = $content->lesson;
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        return view('teacher.contents.edit', compact('course', 'module', 'lesson', 'content'));
    }


    public function update(Request $request, Content $content)
    {
        $lesson = $content->lesson;
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        $data = $request->validate([
            'type'  => 'required|in:text,file,video',
            'title' => 'nullable|string|max:255',
            'body'  => 'nullable|string',
            'file'  => 'nullable|file',
            'video' => 'nullable|file',
            'order' => 'nullable|integer',
        ]);

        if ($request->type === 'text') {
            $request->validate([
                'body' => 'required|string',
            ]);
        }

        if ($request->type === 'file' && $request->hasFile('file')) {
            $request->validate([
                'file' => 'file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png,webp|max:51200',
            ]);
        }

        if ($request->type === 'video' && $request->hasFile('video')) {
            $request->validate([
                'video' => 'file|mimetypes:video/mp4,video/quicktime|max:204800',
            ]);
        }

        if ($request->hasFile('file')) {
            if ($content->file_path) {
                Storage::disk('public')->delete($content->file_path);
            }
            $data['file_path'] = $request->file('file')->store('course/files', 'public');
        }

        if ($request->hasFile('video')) {
            if ($content->video_path) {
                Storage::disk('public')->delete($content->video_path);
            }
            $data['video_path'] = $request->file('video')->store('course/videos', 'public');
        }

        if (!isset($data['order']) || $data['order'] === '' || $data['order'] === null) {
            $maxOrder      = $lesson->contents()
                ->where('id', '!=', $content->id)
                ->max('order');
            $data['order'] = ($maxOrder ?? 0) + 1;
        }

        unset($data['file'], $data['video']);

        $content->update($data);

        return redirect()
            ->route('teacher.courses.modules.lessons.contents.index', [
                'course' => $course->id,
                'module' => $module->id,
                'lesson' => $lesson->id,
            ])
            ->with('success', 'Materi berhasil diupdate.');
    }

   
    public function destroy(Content $content)
    {
        $lesson = $content->lesson;
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        if ($content->file_path) {
            Storage::disk('public')->delete($content->file_path);
        }
        if ($content->video_path) {
            Storage::disk('public')->delete($content->video_path);
        }

        $content->delete();

        return redirect()
            ->route('teacher.courses.modules.lessons.contents.index', [
                'course' => $course->id,
                'module' => $module->id,
                'lesson' => $lesson->id,
            ])
            ->with('success', 'Materi berhasil dihapus.');
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
