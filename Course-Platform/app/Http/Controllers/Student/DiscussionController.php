<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DiscussionMessage;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    /**
     * Tampilkan halaman belajar + diskusi sudah ada di learn.blade.php.
     * Jadi di sini kita hanya pakai endpoint untuk SIMPAN pesan diskusi.
     *
     * Route: POST /student/courses/{course}/discussion
     * Name : student.courses.discussion.store
     */
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        // (Opsional) cek kalau student memang terdaftar di course ini
        /*
        if (! auth()->user()->courses()->where('course_id', $course->id)->exists()) {
            abort(403);
        }
        */

        DiscussionMessage::create([
            'course_id' => $course->id,
            'user_id'   => auth()->id(),
            'message'   => $data['message'],
        ]);

        return back();
    }
}
