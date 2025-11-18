<x-app-layout :title="'Konten: '.$lesson->title">
    <div class="container py-4">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">Konten Lesson</h1>
                <p class="small text-muted mb-0">
                    Lesson: <strong>{{ $lesson->title }}</strong><br>
                    Modul: <strong>{{ $lesson->module->title }}</strong> – 
                    Course: <strong>{{ $lesson->module->course->title }}</strong>
                </p>
            </div>

            {{-- Tombol tambah konten (nested route sudah benar) --}}
            <a href="{{ route('teacher.courses.modules.lessons.contents.create', [
                    'course' => $lesson->module->course_id,
                    'module' => $lesson->module_id,
                    'lesson' => $lesson->id,
                ]) }}"
               class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Konten
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success small mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th>Urutan</th>
                            <th>Jenis</th>
                            <th>Judul</th>
                            <th>Detail</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($contents as $content)
                            <tr>
                                <td>{{ $content->order }}</td>
                                <td>
                                    <span class="badge text-bg-light border">
                                        {{ strtoupper($content->type) }}
                                    </span>
                                </td>
                                <td>{{ $content->title ?? '-' }}</td>
                                <td class="text-muted">
                                    @if($content->type === 'text')
                                        {!! \Illuminate\Support\Str::limit(strip_tags($content->body), 60) !!}

                                    @elseif($content->type === 'file')
                                        @if($content->file_path)
                                            {{-- Jika path relatif di disk "public" --}}
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
                                            {{-- Kalau video_path adalah URL lengkap --}}
                                            @if(Str::startsWith($content->video_path, ['http://','https://']))
                                                <a href="{{ $content->video_path }}" target="_blank">
                                                    <i class="bi bi-play-circle me-1"></i>
                                                    Buka Video
                                                </a>
                                            @else
                                                {{-- Kalau disimpan di storage/public --}}
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
                                    {{-- Edit konten (route shallow) --}}
                                    <a href="{{ route('teacher.contents.edit', $content) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Hapus konten (route shallow) --}}
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
                                <td colspan="5" class="text-center text-muted py-3">
                                    Belum ada konten untuk lesson ini.
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
