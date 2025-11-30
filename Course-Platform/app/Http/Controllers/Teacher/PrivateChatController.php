<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\PrivateThread;
use App\Models\PrivateMessage;
use Illuminate\Http\Request;

class PrivateChatController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

        $threads = PrivateThread::with(['student', 'course'])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->get();

        return view('teacher.chat.index', compact('threads'));
    }

    public function show(PrivateThread $thread)
    {
        $teacher = auth()->user();

        if ($thread->teacher_id !== $teacher->id) {
            abort(403);
        }

        $messages = $thread->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return view('teacher.chat.show', compact('thread', 'messages'));
    }

    public function store(Request $request, PrivateThread $thread)
    {
        $teacher = auth()->user();

        if ($thread->teacher_id !== $teacher->id) {
            abort(403);
        }

        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        PrivateMessage::create([
            'thread_id' => $thread->id,
            'sender_id' => $teacher->id,
            'message'   => $data['message'],
        ]);

        return back();
    }
}
