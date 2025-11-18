<x-app-layout title="Quiz Baru – Teacher">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Buat Quiz Baru</h1>
            <p class="small text-muted mb-0">
                Quiz dapat dihubungkan ke konten lesson dengan tipe <strong>quiz</strong>.
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('teacher.quizzes.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-8">
                        <label class="form-label small">Judul Quiz</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="form-control form-control-sm @error('title') is-invalid @enderror">
                        @error('title') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Nilai Lulus (%)</label>
                        <input type="number" name="pass_score" value="{{ old('pass_score',70) }}"
                               class="form-control form-control-sm @error('pass_score') is-invalid @enderror">
                        @error('pass_score') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('teacher.quizzes.index') }}"
                           class="btn btn-light btn-sm">
                            Batal
                        </a>
                        <button class="btn btn-primary btn-sm">
                            Simpan Quiz
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
