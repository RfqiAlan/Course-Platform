<x-app-layout :title="'Tambah Lesson – '.$module->title">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h5 mb-1">Tambah Lesson</h1>
                <p class="small text-muted mb-0">
                    Modul: <strong>{{ $module->title }}</strong><br>
                    Course: <strong>{{ $course->title }}</strong>
                </p>
            </div>

            <a href="{{ route('teacher.courses.modules.lessons.index', [
                        'course' => $course->id,
                        'module' => $module->id,
                    ]) }}"
               class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('teacher.courses.modules.lessons.store', [
                            'course' => $course->id,
                            'module' => $module->id,
                        ]) }}"
                      method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label small">Judul Lesson</label>
                        <input type="text" name="title"
                               class="form-control form-control-sm @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" required>
                        @error('title')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Deskripsi / Ringkasan</label>
                        <textarea name="description" rows="3"
                                  class="form-control form-control-sm @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Urutan (opsional)</label>
                        <input type="number" name="order"
                               class="form-control form-control-sm @error('order') is-invalid @enderror"
                               value="{{ old('order') }}">
                        @error('order')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('teacher.courses.modules.lessons.index', [
                                    'course' => $course->id,
                                    'module' => $module->id,
                                ]) }}"
                           class="btn btn-light btn-sm">
                            Kembali
                        </a>
                        <button class="btn btn-primary btn-sm">
                            Simpan Lesson
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
