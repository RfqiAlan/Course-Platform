<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DiscussionMessage;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    // (Opsional) halaman khusus diskusi course untuk guru
    public function index(Course $course)
    {
        $messages = DiscussionMessage::where('course_id', $course->id)
            ->with('user')
            ->orderBy('created_at')
            ->get();

        return view('teacher.courses.discussion', compact('course', 'messages'));
    }

    // guru mengirim pesan diskusi
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        // opsional: pastikan course ini milik guru yang login
        /*
        if ($course->teacher_id !== auth()->id()) {
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
