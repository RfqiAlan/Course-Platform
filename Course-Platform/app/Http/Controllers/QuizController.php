<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\LessonUserProgress;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function submit(Request $request, Quiz $quiz)
    {
        $user = auth()->user();

        $quiz->load('questions.options');

        $answers = $request->input('answers', []);
        $correct = 0;
        $total   = $quiz->questions->count();

        foreach ($quiz->questions as $q) {
            $selectedId = $answers[$q->id] ?? null;
            if (!$selectedId) {
                continue;
            }

            $opt = $q->options->firstWhere('id', $selectedId);
            if ($opt && $opt->is_correct) {
                $correct++;
            }
        }

        $score    = $total ? (int) round($correct / $total * 100) : 0;
        $isPassed = $score >= $quiz->pass_score;

        QuizAttempt::create([
            'quiz_id'   => $quiz->id,
            'user_id'   => $user->id,
            'score'     => $score,
            'is_passed' => $isPassed,
            'answers'   => $answers,
        ]);

        // optional: tandai quiz_passed di progress lesson (kalau dikaitkan)
        if ($isPassed && $request->filled('lesson_id')) {
            LessonUserProgress::updateOrCreate(
                ['lesson_id' => $request->lesson_id, 'user_id' => $user->id],
                ['quiz_passed' => true]
            );
        }

        return back()->with('success', "Quiz selesai. Skor kamu: {$score}");
    }
}
