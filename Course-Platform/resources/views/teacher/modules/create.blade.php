<x-app-layout :title="'Tambah Modul – '.$course->title">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h5 mb-1">Tambah Modul</h1>
                <p class="small text-muted mb-0">
                    Course: <strong>{{ $course->title }}</strong>
                </p>
            </div>
            <a href="{{ route('teacher.courses.modules.index', $course) }}"
               class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">

                <div class="mb-3">
                    <h2 class="h6 mb-1">Detail Modul</h2>
                    <p class="small text-muted mb-0">
                        Tambahkan modul baru untuk mengelompokkan lesson dalam course ini.
                    </p>
                </div>

                <form action="{{ route('teacher.courses.modules.store',$course) }}"
                      method="POST" class="row g-4">
                    @csrf
                    <div class="col-lg-8">
                        <label class="form-label small">Judul Modul</label>
                        <input type="text" name="title"
                               class="form-control form-control-sm @error('title') is-invalid @enderror"
                               value="{{ old('title') }}"
                               placeholder="Contoh: Dasar-Dasar Pemrograman">
                        @error('title')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @else
                            <div class="form-text small">Judul modul yang akan dilihat siswa.</div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label small">Urutan</label>
                        <input type="number" name="order"
                               class="form-control form-control-sm"
                               value="{{ old('order', $nextOrder ?? 1) }}">
                        <div class="form-text small">Semakin kecil semakin awal.</div>
                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('teacher.courses.modules.index',$course) }}"
                           class="btn btn-sm btn-outline-secondary">
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
