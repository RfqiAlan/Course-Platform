<x-app-layout :title="'Belajar: '.$course->title">
    <div class="container py-4">
        <div class="row g-3">
            {{-- SIDEBAR --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4" style="position:sticky;top:5rem;">
                    <div class="card-body">
                        <p class="small text-muted mb-2">Kursus</p>
                        <h2 class="h6 mb-3">{{ $course->title }}</h2>
                        <hr>
                        <p class="small text-muted mb-2">Modul & Lesson</p>
                        <div class="list-group list-group-flush small">
                            @foreach($course->modules as $module)
                                <div class="mb-2">
                                    <div class="fw-semibold mb-1">{{ $loop->iteration }}. {{ $module->title }}</div>
                                    @foreach($module->lessons as $lesson)
                                        @php
                                            $isActive = isset($currentLesson) && $currentLesson->id === $lesson->id;
                                        @endphp
                                        <a href="{{ route('student.courses.learn', ['course'=>$course, 'lesson'=>$lesson->id]) }}"
                                           class="d-flex align-items-center justify-content-between px-2 py-1 rounded-3
                                               {{ $isActive ? 'bg-primary-subtle text-primary fw-semibold' : 'text-body' }}">
                                            <span class="text-truncate me-2">
                                                <i class="bi bi-play-circle me-1 text-primary"></i>
                                                {{ $lesson->title }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- KONTEN --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success small mb-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        @isset($currentLesson)
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="small text-muted mb-1">
                                        Lesson {{ $currentLesson->id }}
                                    </p>
                                    <h1 class="h5 mb-1">{{ $currentLesson->title }}</h1>
                                    @if($currentLesson->summary)
                                        <p class="small text-muted mb-0">{{ $currentLesson->summary }}</p>
                                    @endif
                                </div>
                            </div>
                            <hr>

                            @forelse($currentLesson->contents as $content)
                                <div class="mb-4">
                                    @if($content->title)
                                        <h2 class="h6 mb-2">{{ $content->title }}</h2>
                                    @endif

                                    @if($content->type === 'text')
                                        <div class="small" style="line-height:1.6">
                                            {!! $content->body !!}
                                        </div>
                                    @elseif($content->type === 'file' && $content->file_path)
                                        <a href="{{ Storage::url($content->file_path) }}"
                                           class="btn btn-outline-primary btn-sm"
                                           target="_blank">
                                            <i class="bi bi-file-earmark-arrow-down me-1"></i>
                                            Unduh materi
                                        </a>
                                    @elseif($content->type === 'video' && $content->video_path)
                                        <div class="ratio ratio-16x9 rounded-3 overflow-hidden mb-2">
                                            <video controls class="w-100 h-100">
                                                <source src="{{ Storage::url($content->video_path) }}" type="video/mp4">
                                                Browser Anda tidak mendukung video HTML5.
                                            </video>
                                        </div>
                                </div>
                            @empty
                                <p class="small text-muted mb-0">
                                    Belum ada materi di lesson ini.
                                </p>
                            @endforelse

                            <form action="{{ route('student.lessons.mark-done',$currentLesson) }}"
                                  method="POST" class="mt-3">
                                @csrf
                                <button class="btn btn-success">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    Tandai lesson selesai
                                </button>
                            </form>
                        @else
                            <p class="small text-muted mb-0">
                                Silakan pilih lesson di sebelah kiri untuk mulai belajar.
                            </p>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
