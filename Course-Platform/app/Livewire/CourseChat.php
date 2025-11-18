<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class CourseChat extends Component
{
    public Course $course;

    public $messages = [];
    public $newMessage = '';

    public function mount(Course $course)
    {
        $this->course = $course;

        // Dummy data awal (kalau mau diisi dari DB nanti)
        $this->messages = [
            [
                'user' => 'System',
                'text' => 'Gunakan ruang chat ini untuk bertanya ke pengajar.',
                'time' => now()->format('H:i'),
            ],
        ];
    }

    public function sendMessage()
    {
        $text = trim($this->newMessage);
        if ($text === '') return;

        $this->messages[] = [
            'user' => auth()->user()->name ?? 'User',
            'text' => $text,
            'time' => now()->format('H:i'),
        ];

        $this->newMessage = '';
    }

    public function render()
    {
        return view('livewire.course-chat');
    }
}
