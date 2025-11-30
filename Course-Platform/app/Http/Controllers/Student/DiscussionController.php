<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DiscussionMessage;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{

    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        DiscussionMessage::create([
            'course_id' => $course->id,
            'user_id'   => auth()->id(),
            'message'   => $data['message'],
        ]);

        return back();
    }
}
