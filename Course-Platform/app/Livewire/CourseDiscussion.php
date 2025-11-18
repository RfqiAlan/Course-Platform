<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class CourseDiscussion extends Component
{
    public Course $course;

    public $topic = '';
    public $body = '';

    public $threads = [];

    public function mount(Course $course)
    {
        $this->course = $course;

        // Dummy thread awal
        $this->threads = [
            [
                'user' => 'System',
                'topic' => 'Selamat datang di forum diskusi',
                'body' => 'Silakan buat topik terkait materi course ini.',
                'time' => now()->subMinutes(10)->format('H:i'),
            ],
        ];
    }

    public function createThread()
    {
        $this->validate([
            'topic' => 'required|string',
            'body'  => 'required|string',
        ]);

        $this->threads[] = [
            'user'  => auth()->user()->name ?? 'User',
            'topic' => $this->topic,
            'body'  => $this->body,
            'time'  => now()->format('H:i'),
        ];

        $this->topic = '';
        $this->body  = '';
    }

    public function render()
    {
        return view('livewire.course-discussion');
    }
}
