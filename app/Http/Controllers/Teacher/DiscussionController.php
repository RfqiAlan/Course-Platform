<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DiscussionMessage;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function index(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        $discussions = DiscussionMessage::where('course_id', $course->id)
            ->with('user')
            ->orderBy('created_at')
            ->get();

        return view('teacher.courses.discussion', [
            'course'      => $course,
            'discussions' => $discussions,
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        DiscussionMessage::create([
            'course_id' => $course->id,
            'user_id'   => auth()->id(),
            'message'   => $data['message'],
        ]);

        return back();
    }
}
