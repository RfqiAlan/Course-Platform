<x-app-layout :title="'Edit Quiz – '.$quiz->title">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Edit Quiz</h1>
            <p class="small text-muted mb-0">
                Perbarui judul dan nilai lulus quiz.
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('teacher.quizzes.update',$quiz) }}" method="POST" class="row g-3">
                    @csrf @method('PUT')

                    <div class="col-md-8">
                        <label class="form-label small">Judul Quiz</label>
                        <input type="text" name="title" value="{{ old('title',$quiz->title) }}"
                               class="form-control form-control-sm @error('title') is-invalid @enderror">
                        @error('title') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Nilai Lulus (%)</label>
                        <input type="number" name="pass_score" value="{{ old('pass_score',$quiz->pass_score) }}"
                               class="form-control form-control-sm @error('pass_score') is-invalid @enderror">
                        @error('pass_score') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('teacher.quizzes.index') }}"
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
    </div>
</x-app-layout>
