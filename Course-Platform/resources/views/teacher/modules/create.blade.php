<x-app-layout :title="'Tambah Modul – '.$course->title">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Tambah Modul</h1>
            <p class="small text-muted mb-0">
                Course: <strong>{{ $course->title }}</strong>
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('teacher.courses.modules.store',$course) }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-8">
                        <label class="form-label small">Judul Modul</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="form-control form-control-sm @error('title') is-invalid @enderror">
                        @error('title') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Urutan</label>
                        <input type="number" name="order" value="{{ old('order', $nextOrder ?? 1) }}"
                               class="form-control form-control-sm">
                        <div class="form-text small">Semakin kecil semakin awal.</div>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('teacher.courses.modules.index',$course) }}"
                           class="btn btn-light btn-sm">
                            Batal
                        </a>
                        <button class="btn btn-primary btn-sm">
                            Simpan Modul
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
