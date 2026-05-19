<x-app-layout :title="'Edit Konten – '.$lesson->title">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h5 mb-1">Edit Konten Lesson</h1>
                <p class="small text-muted mb-0">
                    Lesson: <strong>{{ $lesson->title }}</strong> – 
                    Modul: <strong>{{ $module->title }}</strong> – 
                    Kursus: <strong>{{ $course->title }}</strong>
                </p>
            </div>

            <a href="{{ route('teacher.courses.modules.lessons.contents.index', [
                    'course' => $course->id,
                    'module' => $module->id,
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
                        Ubah jenis konten, urutan, teks, atau file/video materi.
                    </p>
                </div>

                <form action="{{ route('teacher.contents.update', $content) }}"
                      method="POST" enctype="multipart/form-data"
                      class="row g-4">
                    @csrf
                    @method('PUT')
                    <div class="col-lg-7">
                        <div class="mb-3">
                            <label class="form-label small d-block mb-2">Jenis Konten</label>

                            @php
                                $currentType = old('type', $content->type);
                            @endphp

                            <div class="btn-group w-100" role="group">

                                <input type="radio" class="btn-check" name="type" id="type_text"
                                       value="text" {{ $currentType === 'text' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary btn-sm d-flex flex-column align-items-center py-2"
                                       for="type_text">
                                    <i class="bi bi-card-text mb-1"></i>
                                    Teks
                                </label>

                                <input type="radio" class="btn-check" name="type" id="type_file"
                                       value="file" {{ $currentType === 'file' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary btn-sm d-flex flex-column align-items-center py-2"
                                       for="type_file">
                                    <i class="bi bi-paperclip mb-1"></i>
                                    File
                                </label>

                                <input type="radio" class="btn-check" name="type" id="type_video"
                                       value="video" {{ $currentType === 'video' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary btn-sm d-flex flex-column align-items-center py-2"
                                       for="type_video">
                                    <i class="bi bi-play-circle mb-1"></i>
                                    Video
                                </label>

                            </div>

                            @error('type')
                            <div class="invalid-feedback small d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col-md-8">
                                <label class="form-label small">Judul Konten (opsional)</label>
                                <input type="text" name="title"
                                       value="{{ old('title', $content->title) }}"
                                       class="form-control form-control-sm">
                                <div class="form-text small">Judul akan tampil dalam daftar konten.</div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small">Urutan</label>
                                <input type="number" name="order"
                                       value="{{ old('order', $content->order) }}"
                                       class="form-control form-control-sm">
                                <div class="form-text small">Atur posisi konten.</div>
                            </div>
                        </div>
                        <div>
                            <label class="form-label small">Isi Teks (jika type = text)</label>
                            <textarea name="body" rows="6"
                                      class="form-control form-control-sm @error('body') is-invalid @enderror">{{ old('body', $content->body) }}</textarea>
                            @error('body')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @else
                                <div class="form-text small">Isi dengan penjelasan materi atau ringkasan.</div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-lg-5">

                        <div class="border rounded-3 p-3 bg-light-subtle">
                            <h3 class="h6">Lampiran Materi</h3>
                            <p class="small text-muted mb-3">
                                Unggah ulang file/video jika ingin mengganti materi lama.
                            </p>
                            <div class="mb-3">
                                <label class="form-label small">File Materi (type = file)</label>
                                <input type="file" name="file_path"
                                       class="form-control form-control-sm @error('file_path') is-invalid @enderror">

                                @if($content->file_path)
                                    <div class="form-text small mt-1">
                                        File saat ini:
                                        <a href="{{ asset('storage/'.$content->file_path) }}" target="_blank">
                                            {{ basename($content->file_path) }}
                                        </a>
                                    </div>
                                @endif

                                @error('file_path')
                                    <div class="invalid-feedback small d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">File Video (type = video)</label>
                                <input type="file" name="video_path"
                                       class="form-control form-control-sm @error('video_path') is-invalid @enderror">

                                @if($content->video_path)
                                    <div class="form-text small mt-1">
                                        Video saat ini:
                                        <a href="{{ asset('storage/'.$content->video_path) }}" target="_blank">
                                            {{ basename($content->video_path) }}
                                        </a>
                                    </div>
                                @endif

                                @error('video_path')
                                    <div class="invalid-feedback small d-block">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                        <a href="{{ route('teacher.courses.modules.lessons.contents.index', [
                                'course' => $course->id,
                                'module' => $module->id,
                                'lesson' => $lesson->id,
                            ]) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            Batal
                        </a>

                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
