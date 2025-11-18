<x-app-layout :title="'Edit Soal – '.$question->quiz->title">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Edit Soal Quiz</h1>
            <p class="small text-muted mb-0">
                Quiz: <strong>{{ $question->quiz->title }}</strong>
            </p>
        </div>

        @php
            $oldOptions = old('options');
            if ($oldOptions) {
                $options = $oldOptions;
            } else {
                $options = $question->options
                    ->map(fn($opt) => ['text' => $opt->text, 'is_correct' => $opt->is_correct])
                    ->toArray();
            }
            for ($i = count($options); $i < 4; $i++) {
                $options[] = ['text' => '', 'is_correct' => false];
            }

            $correctOld = old('correct_option');
            if (!is_null($correctOld)) {
                $correctIndex = (int)$correctOld;
            } else {
                $correctIndex = $question->options->search(fn($opt) => $opt->is_correct) ?? 0;
            }
        @endphp

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('teacher.quizzes.questions.update',$question) }}"
                      method="POST" class="row g-3">
                    @csrf @method('PUT')

                    <div class="col-12">
                        <label class="form-label small">Teks Pertanyaan</label>
                        <textarea name="question" rows="3"
                                  class="form-control form-control-sm @error('question') is-invalid @enderror">{{ old('question',$question->question) }}</textarea>
                        @error('question') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label small">Opsi Jawaban</label>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light small">
                                <tr>
                                    <th style="width:50px;">Benar</th>
                                    <th>Teks Opsi</th>
                                </tr>
                                </thead>
                                <tbody class="small">
                                @foreach($options as $i => $opt)
                                    <tr>
                                        <td class="text-center">
                                            <input type="radio"
                                                   name="correct_option"
                                                   value="{{ $i }}"
                                                   {{ $correctIndex === $i ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="text"
                                                   name="options[{{ $i }}][text]"
                                                   value="{{ $opt['text'] }}"
                                                   class="form-control form-control-sm @error("options.$i.text") is-invalid @enderror"
                                                   placeholder="Teks opsi {{ $i+1 }}">
                                            @error("options.$i.text")
                                                <div class="invalid-feedback small">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="form-text small">
                            Pilih salah satu opsi sebagai jawaban yang benar.
                        </div>
                        @error('correct_option')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('teacher.quizzes.questions.index',$question->quiz) }}"
                           class="btn btn-light btn-sm">
                            Kembali
                        </a>
                        <button class="btn btn-primary btn-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('teacher.quizzes.questions.index',$question->quiz) }}"
               class="btn btn-link btn-sm p-0">
                &laquo; Kembali ke daftar soal
            </a>
        </div>
    </div>
</x-app-layout>
            