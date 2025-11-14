<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class LessonController extends Controller
{
    public function enroll(Course $course)
    {
        $user = Auth::user();

        if (! $user->isStudent()) abort(403);

        $user->enrolledCourses()->syncWithoutDetaching([
            $course->id => ['started_at' => now()]
        ]);

        return redirect()->route('lessons.show', [
            'course'  => $course->id,
            'content' => $course->contents()->orderBy('order')->first()->id ?? null,
        ])->with('status', 'Berhasil mengikuti course');
    }

    public function show(Course $course, Content $content)
    {
        $user = Auth::user();

        // pastikan content milik course ini
        if ($content->course_id != $course->id) {
            abort(404);
        }

        // pastikan student sudah enroll
        if (! $user->enrolledCourses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.public.show', $course)
                ->with('error','Silakan ikuti course terlebih dahulu.');
        }

        $contents = $course->contents()->orderBy('order')->get();

        // cek progress content ini
        $pivot = $content->studentsDone()->where('user_id',$user->id)->first();

        return view('lessons.show', [
            'course'   => $course,
            'content'  => $content,
            'contents' => $contents,
            'done'     => $pivot ? true : false,
        ]);
    }

    public function markDone(Content $content)
    {
        $user = Auth::user();

        $course = $content->course;

        if (! $user->enrolledCourses()->where('course_id', $course->id)->exists()) {
            abort(403);
        }

        $user->doneContents()->syncWithoutDetaching([
            $content->id => [
                'is_done'     => true,
                'completed_at'=> now(),
            ]
        ]);

        // cari next content
        $next = $course->contents()
            ->where('order','>', $content->order)
            ->orderBy('order')
            ->first();

        if ($next) {
            return redirect()->route('lessons.show', [
                'course'  => $course->id,
                'content' => $next->id,
            ])->with('status','Materi ditandai selesai, lanjut ke materi berikutnya.');
        }

        // bila konten terakhir: bisa tandai course complete
        $user->enrolledCourses()->updateExistingPivot($course->id, [
            'completed_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('status','Selamat! Anda telah menyelesaikan course ini.');
    }
}

