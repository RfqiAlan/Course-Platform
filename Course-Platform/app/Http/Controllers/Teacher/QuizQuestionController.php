<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizQuestionController extends Controller
{
    public function __construct()
    {
        // Sesuaikan dengan middleware kamu
        // Kalau mau admin juga bisa akses, pakai: role:teacher,admin
        $this->middleware(['auth', 'verified', 'role:teacher']);
    }

    /**
     * Tampilkan semua soal untuk 1 quiz.
     */
    public function index(Quiz $quiz)
    {
        $this->authorizeQuizOwner($quiz);

        $questions = $quiz->questions()
            ->with('options')
            ->orderBy('id')
            ->get();

        return view('teacher.quizzes.questions.index', compact('quiz', 'questions'));
    }

    /**
     * Form tambah soal baru.
     */
    public function create(Quiz $quiz)
    {
        $this->authorizeQuizOwner($quiz);

        return view('teacher.quizzes.questions.create', compact('quiz'));
    }

    /**
     * Simpan soal baru + opsi.
     */
    public function store(Request $request, Quiz $quiz)
    {
        $this->authorizeQuizOwner($quiz);

        // Validasi dasar
        $validated = $request->validate([
            'question'        => ['required', 'string'],
            'options'         => ['required', 'array', 'size:4'], // tepat 4 opsi
            'options.*.text'  => ['required', 'string'],
            'correct_option'  => ['required', 'integer', 'min:0', 'max:3'],
        ], [
            'question.required'       => 'Teks pertanyaan wajib diisi.',
            'options.required'        => 'Minimal harus ada 4 opsi jawaban.',
            'options.*.text.required' => 'Teks setiap opsi wajib diisi.',
            'correct_option.required' => 'Pilih satu jawaban yang benar.',
        ]);

        DB::transaction(function () use ($quiz, $validated) {
            // 1. Buat Question
            $question = $quiz->questions()->create([
                'question' => $validated['question'],
            ]);

            // 2. Buat Options
            foreach ($validated['options'] as $index => $optData) {
                $question->options()->create([
                    'text'       => $optData['text'],
                    'is_correct' => ($index === (int) $validated['correct_option']),
                ]);
            }
        });

        return redirect()
            ->route('teacher.quizzes.questions.index', $quiz)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    /**
     * Form edit soal + opsi.
     */
    public function edit(Question $question)
    {
        $quiz = $question->quiz;
        $this->authorizeQuizOwner($quiz);

        // Load options
        $question->load('options');

        return view('teacher.quizzes.questions.edit', compact('quiz', 'question'));
    }

    /**
     * Update soal + opsi.
     */
    public function update(Request $request, Question $question)
    {
        $quiz = $question->quiz;
        $this->authorizeQuizOwner($quiz);

        $validated = $request->validate([
            'question'        => ['required', 'string'],
            'options'         => ['required', 'array', 'size:4'],
            'options.*.text'  => ['required', 'string'],
            'correct_option'  => ['required', 'integer', 'min:0', 'max:3'],
        ], [
            'question.required'       => 'Teks pertanyaan wajib diisi.',
            'options.required'        => 'Minimal harus ada 4 opsi jawaban.',
            'options.*.text.required' => 'Teks setiap opsi wajib diisi.',
            'correct_option.required' => 'Pilih satu jawaban yang benar.',
        ]);

        DB::transaction(function () use ($question, $validated) {
            // 1. Update teks soal
            $question->update([
                'question' => $validated['question'],
            ]);

            // 2. Hapus semua opsi lama
            $question->options()->delete();

            // 3. Buat ulang opsi baru sesuai input
            foreach ($validated['options'] as $index => $optData) {
                $question->options()->create([
                    'text'       => $optData['text'],
                    'is_correct' => ($index === (int) $validated['correct_option']),
                ]);
            }
        });

        return redirect()
            ->route('teacher.quizzes.questions.index', $quiz)
            ->with('success', 'Soal berhasil diperbarui.');
    }

    /**
     * Hapus 1 soal beserta opsi-opsinya.
     */
    public function destroy(Question $question)
    {
        $quiz = $question->quiz;
        $this->authorizeQuizOwner($quiz);

        DB::transaction(function () use ($question) {
            $question->options()->delete();
            $question->delete();
        });

        return redirect()
            ->route('teacher.quizzes.questions.index', $quiz)
            ->with('success', 'Soal berhasil dihapus.');
    }

    /**
     * Pastikan quiz ini milik teacher yang login (atau admin kalau kamu izinkan).
     */
    protected function authorizeQuizOwner(Quiz $quiz): void
    {
        $user = auth()->user();

        // Kalau kamu punya method isAdmin()/isTeacher() di model User
        if ($user->isAdmin()) {
            return; // admin boleh akses semua
        }

        // Hanya teacher pemilik quiz yang boleh
        if ($user->id !== $quiz->teacher_id) {
            abort(403, 'Anda tidak berhak mengelola quiz ini.');
        }
    }
}
