<?php

namespace App\Livewire;

use App\Models\Lesson;
use App\Models\Quiz;
use Livewire\Component;

class QuizRunner extends Component
{
    public Quiz $quiz;
    public Lesson $lesson;

    public array $answers = [];
    public ?int $score = null;
    public ?bool $isPassed = null;

    public function mount(Quiz $quiz, Lesson $lesson)
    {
        $this->quiz = $quiz->load('questions.options');
        $this->lesson = $lesson;
    }

    public function submit()
    {
        $total = $this->quiz->questions->count();
        if ($total === 0) {
            $this->addError('quiz', 'Quiz ini belum memiliki soal.');
            return;
        }

        $correct = 0;

        foreach ($this->quiz->questions as $question) {
            $selectedOptionId = $this->answers[$question->id] ?? null;
            if (!$selectedOptionId) {
                continue;
            }
            $option = $question->options->firstWhere('id', $selectedOptionId);
            if ($option && $option->is_correct) {
                $correct++;
            }
        }

        $this->score = (int) round(($correct / $total) * 100);
        $this->isPassed = $this->score >= $this->quiz->pass_score;

        session()->flash('quiz_message', 'Quiz telah dinilai.');
    }

    public function render()
    {
        return view('livewire.quiz-runner');
    }
}
