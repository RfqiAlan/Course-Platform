<x-app-layout :title="'Tambah Soal – '.$quiz->title">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Tambah Soal Quiz</h1>
            <p class="small text-muted mb-0">
                Quiz: <strong>{{ $quiz->title }}</strong>
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('teacher.quizzes.questions.store',$quiz) }}"
                      method="POST" class="row g-3">
                    @csrf

                    <div class="col-12">
                        <label class="form-label small">Teks Pertanyaan</label>
                        <textarea name="question" rows="3"
                                  class="form-control form-control-sm @error('question') is-invalid @enderror">{{ old('question') }}</textarea>
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
                                @for($i = 0; $i < 4; $i++)
                                    <tr>
                                        <td class="text-center">
                                            <input type="radio"
                                                   name="correct_option"
                                                   value="{{ $i }}"
                                                   {{ old('correct_option') == $i ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="text"
                                                   name="options[{{ $i }}][text]"
                                                   value="{{ old("options.$i.text") }}"
                                                   class="form-control form-control-sm @error("options.$i.text") is-invalid @enderror"
                                                   placeholder="Teks opsi {{ $i+1 }}">
                                            @error("options.$i.text")
                                                <div class="invalid-feedback small">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                @endfor
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
                        <a href="{{ route('teacher.quizzes.questions.index',$quiz) }}"
                           class="btn btn-light btn-sm">
                            Batal
                        </a>
                        <button class="btn btn-primary btn-sm">
                            Simpan Soal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('teacher.quizzes.questions.index',$quiz) }}"
               class="btn btn-link btn-sm p-0">
                &laquo; Kembali ke daftar soal
            </a>
        </div>
    </div>
</x-app-layout>
