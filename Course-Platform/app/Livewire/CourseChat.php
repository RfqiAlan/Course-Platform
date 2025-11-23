<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\DiscussionMessage;

use App\Events\NewChatMessage;

class CourseChat extends Component
{
    public Course $course;
    public int $courseId;

    // ✅ hanya pakai ini, jangan ada $messages lagi
    public $chatMessages;

    public string $newMessage = '';

    public function mount(Course $course): void
    {
        $this->course   = $course;
        $this->courseId = $course->id;

        $this->loadMessages();
    }

    public function loadMessages(): void
    {
        $this->chatMessages = ChatMessage::with('user')
            ->where('course_id', $this->course->id)
            ->orderBy('created_at')
            ->get();
    }

    public function send(): void
    {
        if (! auth()->check()) {
            return;
        }

        // ✅ VALIDASI langsung di sini
        $this->validate([
            'newMessage' => 'required|string|max:1000',
        ]);

        $message = ChatMessage::create([
            'course_id' => $this->course->id,
            'user_id'   => auth()->id(),
            'message'   => $this->newMessage,
        ]);

        // broadcast ke client lain (realtime)
        event(new NewChatMessage($message));

        // pastikan $chatMessages tidak null
        if ($this->chatMessages === null) {
            $this->chatMessages = collect();
        }

        // tampilkan langsung ke pengirim
        $this->chatMessages->push($message->load('user'));

        // kosongkan input
        $this->newMessage = '';
    }

    protected function getListeners(): array
    {
        return [
            "echo-private:course.{$this->courseId},NewChatMessage" => 'messageReceived',
        ];
    }

    public function messageReceived($payload): void
    {
        // kalau pesan dari diri sendiri, sudah ditambahkan di send()
        if (auth()->check() && $payload['user']['id'] === auth()->id()) {
            return;
        }

        if ($this->chatMessages === null) {
            $this->chatMessages = collect();
        }

        $this->chatMessages->push((object) [
            'id'         => $payload['id'],
            'course_id'  => $payload['course_id'],
            'message'    => $payload['message'],
            'created_at' => $payload['created_at'],
            'user'       => (object) $payload['user'],
        ]);
    }

    public function render()
    {
        return view('livewire.course-chat');
    }
}
