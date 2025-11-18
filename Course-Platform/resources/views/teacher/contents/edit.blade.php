<x-app-layout :title="'Edit Konten – '.$lesson->title">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Edit Konten Lesson</h1>
            <p class="small text-muted mb-0">
                Lesson: <strong>{{ $lesson->title }}</strong> –
                Modul: <strong>{{ $module->title }}</strong> –
                Kursus: <strong>{{ $course->title }}</strong>
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('teacher.contents.update', $content) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="row g-3">
                    @csrf
                    @method('PUT')

                    {{-- TYPE --}}
                    <div class="col-md-4">
                        <label class="form-label small">Jenis Konten</label>
                        <select name="type"
                                class="form-select form-select-sm @error('type') is-invalid @enderror">
                            @php
                                $currentType = old('type', $content->type);
                            @endphp
                            <option value="text"  @selected($currentType === 'text')>Teks</option>
                            <option value="file"  @selected($currentType === 'file')>File</option>
                            <option value="video" @selected($currentType === 'video')>Video</option>
                            <option value="quiz"  @selected($currentType === 'quiz')>Quiz</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- TITLE --}}
                    <div class="col-md-4">
                        <label class="form-label small">Judul Konten (opsional)</label>
                        <input type="text" name="title"
                               value="{{ old('title', $content->title) }}"
                               class="form-control form-control-sm @error('title') is-invalid @enderror">
                        @error('title')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ORDER --}}
                    <div class="col-md-4">
                        <label class="form-label small">Urutan</label>
                        <input type="number" name="order"
                               value="{{ old('order', $content->order ?? 1) }}"
                               class="form-control form-control-sm @error('order') is-invalid @enderror">
                        @error('order')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- BODY (text) --}}
                    <div class="col-12">
                        <label class="form-label small">Isi Teks (jika type = text)</label>
                        <textarea name="body" rows="4"
                                  class="form-control form-control-sm @error('body') is-invalid @enderror">{{ old('body', $content->body) }}</textarea>
                        @error('body')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- FILE (file_path) --}}
                    <div class="col-md-6">
                        <label class="form-label small">File Materi (jika type = file)</label>
                        <input type="file" name="file_path"
                               class="form-control form-control-sm @error('file_path') is-invalid @enderror">
                        <div class="form-text small">
                            PDF, DOCX, PPT, ZIP, RAR.
                            @if($content->file_path)
                                <br>
                                File saat ini:
                                <a href="{{ asset('storage/'.$content->file_path) }}" target="_blank">
                                    Lihat / download
                                </a>
                            @endif
                        </div>
                        @error('file_path')
                            <div class="invalid-feedback small d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- VIDEO (video_path) --}}
                    <div class="col-md-6">
                        <label class="form-label small">File Video (jika type = video)</label>
                        <input type="file" name="video_path"
                               class="form-control form-control-sm @error('video_path') is-invalid @enderror">
                        <div class="form-text small">
                            Format MP4 disarankan.
                            @if($content->video_path)
                                <br>
                                Video saat ini:
                                <a href="{{ asset('storage/'.$content->video_path) }}" target="_blank">
                                    Lihat / buka
                                </a>
                            @endif
                        </div>
                        @error('video_path')
                            <div class="invalid-feedback small d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- QUIZ --}}
                    <div class="col-12">
                        <label class="form-label small">Pilih Quiz (jika type = quiz)</label>
                        <select name="quiz_id"
                                class="form-select form-select-sm @error('quiz_id') is-invalid @enderror">
                            <option value="">-- Pilih Quiz --</option>
                            @foreach($quizzes as $quiz)
                                <option value="{{ $quiz->id }}"
                                        @selected(old('quiz_id', $content->quiz_id) == $quiz->id)>
                                    {{ $quiz->title }} (Lulus: {{ $quiz->pass_score }}%)
                                </option>
                            @endforeach
                        </select>
                        @error('quiz_id')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- BUTTONS --}}
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('teacher.courses.modules.lessons.contents.index', [
                                    'course' => $course->id,
                                    'module' => $module->id,
                                    'lesson' => $lesson->id,
                                ]) }}"
                           class="btn btn-sm btn-outline-secondary">
                            Kembali ke Konten Lesson
                        </a>

                        <button class="btn btn-primary btn-sm">
                            Update Konten
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
