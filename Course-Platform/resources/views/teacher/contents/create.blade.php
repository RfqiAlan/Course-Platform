<x-app-layout :title="'Tambah Konten – '.$lesson->title">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Tambah Konten Lesson</h1>
            <p class="small text-muted mb-0">
                Lesson: <strong>{{ $lesson->title }}</strong> –
                Modul: <strong>{{ $lesson->module->title }}</strong> –
                Kursus: <strong>{{ $course->title }}</strong>
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('teacher.courses.modules.lessons.contents.store', [
                        'course' => $lesson->module->course_id,
                        'module' => $lesson->module_id,
                        'lesson' => $lesson->id,
                    ]) }}"
                      method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf

                    <div class="col-md-4">
                        <label class="form-label small">Jenis Konten</label>
                        <select name="type"
                                class="form-select form-select-sm @error('type') is-invalid @enderror">
                            <option value="text"  @selected(old('type')==='text')>Teks</option>
                            <option value="file"  @selected(old('type')==='file')>File</option>
                            <option value="video" @selected(old('type')==='video')>Video</option>
                            <option value="quiz"  @selected(old('type')==='quiz')>Quiz</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Judul Konten (opsional)</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Urutan</label>
                        <input type="number" name="order" value="{{ old('order', $nextOrder ?? 1) }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="col-12">
                        <label class="form-label small">Isi Teks (jika type = text)</label>
                        <textarea name="body" rows="4"
                                  class="form-control form-control-sm @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
                        @error('body')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">File Materi (jika type = file)</label>
                        <input type="file" name="file"
                               class="form-control form-control-sm @error('file') is-invalid @enderror">
                        <div class="form-text small">PDF, DOCX, PPT, ZIP, RAR.</div>
                        @error('file')
                            <div class="invalid-feedback small d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">File Video (jika type = video)</label>
                        <input type="file" name="video"
                               class="form-control form-control-sm @error('video') is-invalid @enderror">
                        <div class="form-text small">Format MP4 disarankan.</div>
                        @error('video')
                            <div class="invalid-feedback small d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label small">Pilih Quiz (jika type = quiz)</label>
                        <select name="quiz_id"
                                class="form-select form-select-sm @error('quiz_id') is-invalid @enderror">
                            <option value="">-- Pilih Quiz --</option>
                            @foreach($quizzes as $quiz)
                                <option value="{{ $quiz->id }}" @selected(old('quiz_id') == $quiz->id)>
                                    {{ $quiz->title }} (Lulus: {{ $quiz->pass_score }}%)
                                </option>
                            @endforeach
                        </select>
                        @error('quiz_id')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('teacher.lessons.show', $lesson) }}"
   class="btn btn-sm btn-outline-secondary">
    Kembali ke Lesson
</a>

                        <button class="btn btn-primary btn-sm">
                            Simpan Konten
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
