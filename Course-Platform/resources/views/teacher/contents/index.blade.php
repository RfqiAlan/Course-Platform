<x-app-layout :title="'Konten: '.$lesson->title">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h5 mb-1">Konten Lesson</h1>
                <p class="small text-muted mb-0">
                    Lesson: <strong>{{ $lesson->title }}</strong><br>
                    Modul: <strong>{{ $lesson->module->title }}</strong> – 
                    Course: <strong>{{ $lesson->module->course->title }}</strong>
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('teacher.courses.modules.lessons.index', [
                        'course' => $lesson->module->course_id,
                        'module' => $lesson->module_id,
                    ]) }}"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('teacher.courses.modules.lessons.contents.create', [
                        'course' => $lesson->module->course_id,
                        'module' => $lesson->module_id,
                        'lesson' => $lesson->id,
                    ]) }}"
                   class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Konten
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success small mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th style="width: 80px;">Urutan</th>
                            <th style="width: 120px;">Jenis</th>
                            <th>Judul</th>
                            <th>Detail</th>
                            <th class="text-end" style="width: 170px;">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($contents as $content)
                            <tr>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">
                                        {{ $content->order }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $label = strtoupper($content->type);
                                    @endphp

                                    @if($content->type === 'text')
                                        <span class="badge bg-light text-secondary border rounded-pill px-3">
                                            <i class="bi bi-card-text me-1"></i>{{ $label }}
                                        </span>
                                    @elseif($content->type === 'file')
                                        <span class="badge bg-info-subtle text-info rounded-pill px-3">
                                            <i class="bi bi-paperclip me-1"></i>{{ $label }}
                                        </span>
                                    @elseif($content->type === 'video')
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3">
                                            <i class="bi bi-play-circle me-1"></i>{{ $label }}
                                        </span>
                                    @elseif($content->type === 'quiz')
                                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3">
                                            <i class="bi bi-question-circle me-1"></i>{{ $label }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">
                                            {{ $label }}
                                        </span>
                                    @endif
                                </td>
                                <td class="fw-semibold">
                                    {{ $content->title ?? '-' }}
                                </td>
                                <td class="text-muted">
                                    @if($content->type === 'text')
                                        {!! \Illuminate\Support\Str::limit(strip_tags($content->body), 80) !!}

                                    @elseif($content->type === 'file')
                                        @if($content->file_path)
                                            <a href="{{ asset('storage/'.$content->file_path) }}"
                                               target="_blank">
                                                <i class="bi bi-paperclip me-1"></i>
                                                {{ basename($content->file_path) }}
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif

                                    @elseif($content->type === 'video')
                                        @if($content->video_path)
                                            @if(\Illuminate\Support\Str::startsWith($content->video_path, ['http://','https://']))
                                                <a href="{{ $content->video_path }}" target="_blank">
                                                    <i class="bi bi-play-circle me-1"></i>
                                                    Buka Video
                                                </a>
                                            @else
                                                <a href="{{ asset('storage/'.$content->video_path) }}"
                                                   target="_blank">
                                                    <i class="bi bi-play-circle me-1"></i>
                                                    Buka Video
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-muted">Tidak ada video</span>
                                        @endif

                                    @elseif($content->type === 'quiz')
                                        Quiz: {{ $content->quiz->title ?? '-' }}
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('teacher.contents.edit', $content) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('teacher.contents.destroy', $content) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus konten ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <div class="mb-2">
                                        <i class="bi bi-file-earmark-text fs-3 d-block mb-1"></i>
                                        Belum ada konten untuk lesson ini.
                                    </div>
                                    <a href="{{ route('teacher.courses.modules.lessons.contents.create', [
                                            'course' => $lesson->module->course_id,
                                            'module' => $lesson->module_id,
                                            'lesson' => $lesson->id,
                                        ]) }}"
                                       class="btn btn-primary btn-sm">
                                        Tambah Konten Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
