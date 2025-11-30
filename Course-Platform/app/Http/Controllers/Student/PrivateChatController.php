<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\PrivateThread;
use App\Models\PrivateMessage;
use Illuminate\Http\Request;

class PrivateChatController extends Controller
{
 
    public function store(Request $request, Course $course)
    {
        $student = auth()->user();

        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        $teacher = $course->teacher; // pastikan relasi course->teacher 

        $thread = PrivateThread::firstOrCreate([
            'course_id'  => $course->id,
            'teacher_id' => $teacher->id,
            'student_id' => $student->id,
        ]);

        // simpan pesan
        PrivateMessage::create([
            'thread_id' => $thread->id,
            'sender_id' => $student->id,
            'message'   => $data['message'],
        ]);

        return back();
    }
}
