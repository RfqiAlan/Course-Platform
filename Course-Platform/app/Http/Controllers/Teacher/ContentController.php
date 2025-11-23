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
    /**
     * List konten untuk 1 lesson (nested).
     * Route: teacher.courses.modules.lessons.contents.index
     * URL  : /teacher/courses/{course}/modules/{module}/lessons/{lesson}/contents
     */
    public function index(Course $course, Module $module, Lesson $lesson)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);
        abort_unless($lesson->module_id === $module->id, 404);

        $contents = $lesson->contents()->orderBy('order')->get();

        return view('teacher.contents.index', compact('course', 'module', 'lesson', 'contents'));
    }

    /**
     * Form tambah konten (nested).
     * Route: teacher.courses.modules.lessons.contents.create
     */
    public function create(Course $course, Module $module, Lesson $lesson)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);
        abort_unless($lesson->module_id === $module->id, 404);

        return view('teacher.contents.create', [
            'course' => $course,
            'module' => $module,
            'lesson' => $lesson,
        ]);
    }

    /**
     * Simpan konten (nested).
     * Route: teacher.courses.modules.lessons.contents.store
     */
    public function store(Request $request, Course $course, Module $module, Lesson $lesson)
    {
        $this->authorizeCourse($course);
        abort_unless($module->course_id === $course->id, 404);
        abort_unless($lesson->module_id === $module->id, 404);

        $data = $request->validate([
            'type' => 'required|in:text,file,video',
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'file_path' => 'nullable|file',
            'video_path' => 'nullable|file',
            'order' => 'nullable|integer',
        ]);

        // jika order kosong, set max+1
        if (!isset($data['order']) || $data['order'] === '' || $data['order'] === null) {
            $maxOrder = $lesson->contents()->max('order');
            $data['order'] = ($maxOrder ?? 0) + 1;
        }

        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('course/files', 'public');
        }

        if ($request->hasFile('video_path')) {
            $data['video_path'] = $request->file('video_path')->store('course/videos', 'public');
        }

        $data['lesson_id'] = $lesson->id;

        Content::create($data);

        return redirect()
            ->route('teacher.courses.modules.lessons.contents.index', [
                'course' => $course->id,
                'module' => $module->id,
                'lesson' => $lesson->id,
            ])
            ->with('success', 'Materi berhasil dibuat.');
    }

    /**
     * Form edit konten (shallow).
     * Route: teacher.contents.edit
     * URL  : /teacher/contents/{content}/edit
     */
    public function edit(Content $content)
    {
        $lesson = $content->lesson;
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        return view('teacher.contents.edit', compact('course', 'module', 'lesson', 'content'));
    }

    /**
     * Update konten (shallow).
     * Route: teacher.contents.update
     * URL  : /teacher/contents/{content}
     */
    public function update(Request $request, Content $content)
    {
        $lesson = $content->lesson;
        $module = $lesson->module;
        $course = $module->course;

        $this->authorizeCourse($course);

        $data = $request->validate([
            'type' => 'required|in:text,file,video',
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'file_path' => 'nullable|file',
            'video_path' => 'nullable|file',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('file_path')) {
            if ($content->file_path) {
                Storage::disk('public')->delete($content->file_path);
            }
            $data['file_path'] = $request->file('file_path')->store('course/files', 'public');
        }

        if ($request->hasFile('video_path')) {
            if ($content->video_path) {
                Storage::disk('public')->delete($content->video_path);
            }
            $data['video_path'] = $request->file('video_path')->store('course/videos', 'public');
        }

        // kalau order diubah jadi kosong, auto lagi
        if (!isset($data['order']) || $data['order'] === '' || $data['order'] === null) {
            $maxOrder = $lesson->contents()
                ->where('id', '!=', $content->id)
                ->max('order');

            $data['order'] = ($maxOrder ?? 0) + 1;
        }

        $content->update($data);

        return redirect()
            ->route('teacher.courses.modules.lessons.contents.index', [
                'course' => $course->id,
                'module' => $module->id,
                'lesson' => $lesson->id,
            ])
            ->with('success', 'Materi berhasil diupdate.');
    }

    /**
     * Hapus konten (shallow).
     * Route: teacher.contents.destroy
     * URL  : /teacher/contents/{content}
     */
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

    /**
     * Hanya teacher pemilik course yang boleh akses.
     */
    protected function authorizeCourse(Course $course): void
    {
        abort_unless($course->teacher_id === auth()->id(), 403);
    }
}
