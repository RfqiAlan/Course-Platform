<x-app-layout :title="'Edit Lesson – '.$lesson->title">
    <div class="container py-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h5 mb-1">Edit Lesson</h1>
                <p class="small text-muted mb-0">
                    Modul: <strong>{{ $lesson->module->title }}</strong> – 
                    Course: <strong>{{ $lesson->module->course->title }}</strong>
                </p>
            </div>

            {{-- KEMBALI KE DAFTAR LESSON (ROUTE DIBETULKAN) --}}
            <a href="{{ route('teacher.courses.modules.lessons.index', [
                    'course' => $lesson->module->course_id,
                    'module' => $lesson->module_id,
                ]) }}"
               class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">

                <div class="mb-4">
                    <h2 class="h6 mb-1">Detail Lesson</h2>
                    <p class="small text-muted mb-0">
                        Perbarui judul, urutan, dan ringkasan lesson agar lebih jelas bagi siswa.
                    </p>
                </div>

                <form action="{{ route('teacher.lessons.update',$lesson) }}"
                      method="POST" class="row g-4">
                    @csrf 
                    @method('PUT')

                    {{-- JUDUL & URUTAN --}}
                    <div class="col-lg-8">
                        <label class="form-label small">Judul Lesson</label>
                        <input type="text" name="title" 
                               value="{{ old('title',$lesson->title) }}"
                               class="form-control form-control-sm @error('title') is-invalid @enderror"
                               placeholder="Contoh: Pendahuluan Konsep Dasar">
                        @error('title')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @else
                            <div class="form-text small">
                                Judul akan terlihat di daftar lesson course ini.
                            </div>
                        @enderror
                    </div>

                    <div class="col-lg-4">
                        <label class="form-label small">Urutan</label>
                        <input type="number" name="order" 
                               value="{{ old('order',$lesson->order) }}"
                               class="form-control form-control-sm @error('order') is-invalid @enderror">
                        @error('order')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @else
                            <div class="form-text small">
                                Tentukan posisi lesson dalam modul.
                            </div>
                        @enderror
                    </div>

                    {{-- RINGKASAN --}}
                    <div class="col-12">
                        <label class="form-label small">Ringkasan (opsional)</label>
                        <textarea name="summary" rows="4"
                                  class="form-control form-control-sm @error('summary') is-invalid @enderror"
                                  placeholder="Tuliskan ringkasan singkat tentang isi lesson ini.">{{ old('summary',$lesson->summary) }}</textarea>
                        @error('summary')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @else
                            <div class="form-text small">
                                Ringkasan membantu siswa memahami konteks sebelum mulai belajar.
                            </div>
                        @enderror
                    </div>

                    {{-- BUTTONS --}}
                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                        <a href="{{ route('teacher.courses.modules.lessons.index', [
                                'course' => $lesson->module->course_id,
                                'module' => $lesson->module_id,
                            ]) }}"
                           class="btn btn-sm btn-outline-secondary">
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
