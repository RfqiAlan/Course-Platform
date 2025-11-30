<x-app-layout :title="'Tambah Konten – '.$lesson->title">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h5 mb-1">Tambah Konten Lesson</h1>
                <p class="small text-muted mb-0">
                    Lesson: <strong>{{ $lesson->title }}</strong> –
                    Modul: <strong>{{ $lesson->module->title }}</strong> –
                    Kursus: <strong>{{ $course->title }}</strong>
                </p>
            </div>
            <a href="{{ route('teacher.courses.modules.lessons.contents.index', [
                    'course' => $lesson->module->course_id,
                    'module' => $lesson->module_id,
                    'lesson' => $lesson->id,
                ]) }}"
               class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="mb-4">
                    <h2 class="h6 mb-1">Detail Konten</h2>
                    <p class="small text-muted mb-0">
                        Pilih jenis konten, atur urutan, dan lengkapi materi teks maupun lampirannya.
                    </p>
                </div>

                <form action="{{ route('teacher.courses.modules.lessons.contents.store', [
                        'course' => $lesson->module->course_id,
                        'module' => $lesson->module_id,
                        'lesson' => $lesson->id,
                    ]) }}"
                      method="POST" enctype="multipart/form-data" class="row g-4">
                    @csrf
                    <div class="col-lg-7">
                        <div class="mb-3">
                            <label class="form-label small d-block mb-2">Jenis Konten</label>

                            @php
                                $oldType = old('type', 'text');
                            @endphp

                            <div class="btn-group w-100" role="group" aria-label="Jenis konten">
                                <input type="radio" class="btn-check" name="type" id="type_text"
                                       value="text" autocomplete="off" {{ $oldType === 'text' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary btn-sm d-flex flex-column align-items-center py-2"
                                       for="type_text" style="font-size: .78rem;">
                                    <i class="bi bi-card-text mb-1"></i>
                                    Teks
                                </label>

                                <input type="radio" class="btn-check" name="type" id="type_file"
                                       value="file" autocomplete="off" {{ $oldType === 'file' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary btn-sm d-flex flex-column align-items-center py-2"
                                       for="type_file" style="font-size: .78rem;">
                                    <i class="bi bi-paperclip mb-1"></i>
                                    File
                                </label>

                                <input type="radio" class="btn-check" name="type" id="type_video"
                                       value="video" autocomplete="off" {{ $oldType === 'video' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary btn-sm d-flex flex-column align-items-center py-2"
                                       for="type_video" style="font-size: .78rem;">
                                    <i class="bi bi-play-circle mb-1"></i>
                                    Video
                                </label>
                            </div>

                            @error('type')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @else
                            @enderror
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col-md-8">
                                <label class="form-label small">Judul Konten (opsional)</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                       class="form-control form-control-sm"
                                       placeholder="Contoh: Pengantar Konsep Dasar">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small">Urutan</label>
                                <input type="number" name="order" value="{{ old('order', $nextOrder ?? 1) }}"
                                       class="form-control form-control-sm">
                            </div>
                        </div>
                        <div>
                            <label class="form-label small">Isi Teks (jika type = text)</label>
                            <textarea name="body" rows="6"
                                      class="form-control form-control-sm @error('body') is-invalid @enderror"
                                      placeholder="Tulis materi teks untuk lesson di sini...">{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @else
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-5">

                        <div class="border rounded-3 p-3 p-md-3 bg-light-subtle mb-3">
                            <h3 class="h6 mb-2">Lampiran Materi</h3>
                          
                            <div class="mb-3">
                                <label class="form-label small">File Materi (jika type = file)</label>
                                <input type="file" name="file"
                                       class="form-control form-control-sm @error('file') is-invalid @enderror">
                                <div class="form-text small">Format: PDF, DOCX, PPT, ZIP, RAR.</div>
                                @error('file')
                                    <div class="invalid-feedback small d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label small">File Video (jika type = video)</label>
                                <input type="file" name="video"
                                       class="form-control form-control-sm @error('video') is-invalid @enderror">
                                <div class="form-text small">
                                    Disarankan format MP4 agar lebih stabil di berbagai perangkat.
                                </div>
                                @error('video')
                                    <div class="invalid-feedback small d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                        <a href="{{ route('teacher.courses.modules.lessons.contents.index', [
                                'course' => $lesson->module->course_id,
                                'module' => $lesson->module_id,
                                'lesson' => $lesson->id,
                            ]) }}"
                           class="btn btn-sm btn-outline-secondary">
                            Batal
                        </a>

                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-save me-1"></i> Simpan Konten
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
