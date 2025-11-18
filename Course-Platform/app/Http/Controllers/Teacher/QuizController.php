<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::latest()->paginate(10);

        return view('teacher.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('teacher.quizzes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'pass_score' => 'required|integer|min:0|max:100',
        ]);

        Quiz::create($data);

        return redirect()->route('teacher.quizzes.index')
            ->with('success','Quiz berhasil dibuat.');
    }

    public function edit(Quiz $quiz)
    {
        return view('teacher.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'pass_score' => 'required|integer|min:0|max:100',
        ]);

        $quiz->update($data);

        return redirect()->route('teacher.quizzes.index')
            ->with('success','Quiz berhasil diupdate.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('teacher.quizzes.index')
            ->with('success','Quiz berhasil dihapus.');
    }
}
