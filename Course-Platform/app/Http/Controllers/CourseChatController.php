<?php
namespace App\Http\Controllers;
use App\Models\DiscussionMessage;


use App\Models\Course;
use Illuminate\Http\Request;

class CourseChatController extends Controller
{
    // ambil chat + tampilkan
    public function index(Course $course)
    {
        // aman-kan akses
        if (!auth()->user()->canAccessCourse($course)) {
            abort(403);
        }

        $messages = DiscussionMessage::where('course_id', $course->id)
            ->with('user')
            ->orderBy('created_at')
            ->get();

        return view('components.course-chat-box', compact('course', 'messages'));
    }

    // kirim pesan
    public function store(Request $request, Course $course)
    {
        if (!auth()->user()->canAccessCourse($course)) {
            abort(403);
        }

        $data = $request->validate(['message' => 'required|string']);

        DiscussionMessage::create([
            'course_id' => $course->id,
            'user_id'   => auth()->id(),
            'message'   => $data['message'],
        ]);

        return back(); // reload halaman
    }
}
