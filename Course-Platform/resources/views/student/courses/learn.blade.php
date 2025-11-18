<x-app-layout :title="'Belajar: '.$course->title">
    <div class="container-fluid py-3">
        <div class="row g-3">
            
            {{-- ========================= --}}
            {{-- SIDEBAR KIRI (MODUL & LESSON) --}}
            {{-- ========================= --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4" style="position: sticky; top: 80px;">
                    <div class="card-body p-3">
                        <h6 class="fw-semibold mb-2">{{ $course->title }}</h6>
                        <p class="small text-muted mb-3">Daftar Modul & Lesson</p>

                        @foreach($course->modules as $m)
                            <div class="mb-3">
                                <div class="fw-semibold small text-primary">
                                    Modul {{ $loop->iteration }}: {{ $m->title }}
                                </div>

                                <ul class="list-unstyled ms-3 mt-2">
                                    @foreach($m->lessons as $l)
                                        @php
                                            $active = isset($currentLesson) && $l->id === $currentLesson->id;
                                        @endphp

                                        <li class="mb-1">
                                            <a href="{{ route('student.courses.learn', [$course->id, 'lesson' => $l->id]) }}"
                                               class="d-flex align-items-center p-2 rounded-3 small
                                               {{ $active ? 'bg-primary text-white fw-semibold' : 'bg-light text-dark' }}"
                                               style="text-decoration:none;">
                                                <i class="bi bi-play-circle me-2"></i> 
                                                <span class="text-truncate">{{ $l->title }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ========================= --}}
            {{-- KONTEN UTAMA (LESSON DETAIL) --}}
            {{-- ========================= --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">

                        @isset($currentLesson)

                            {{-- ===== HEADER LESSON ===== --}}
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="small text-muted mb-1">
                                        Lesson {{ $currentLesson->order }}
                                    </p>
                                    <h4 class="fw-bold mb-1">{{ $currentLesson->title }}</h4>
                                    <p class="text-muted small">{{ $currentLesson->summary }}</p>
                                </div>
                            </div>

                            <hr class="my-3">

                            {{-- ===== LOOP KONTEN LESSON ===== --}}
                            @forelse($currentLesson->contents as $content)

                                {{-- TEXT --}}
                                @if($content->type === 'text')
                                    <div class="mb-4">
                                        @if($content->title)
                                            <h5 class="fw-semibold mb-2">{{ $content->title }}</h5>
                                        @endif

                                        <div class="small text-body" style="line-height:1.7;">
                                            {!! $content->body !!}
                                        </div>
                                    </div>
                                @endif

                                {{-- FILE --}}
                                @if($content->type === 'file')
                                    <div class="mb-4">
                                        <h6 class="fw-semibold">{{ $content->title }}</h6>
                                        <a href="{{ Storage::url($content->file_path) }}"
                                           class="btn btn-outline-primary btn-sm"
                                           target="_blank">
                                            <i class="bi bi-file-earmark-arrow-down me-1"></i> Unduh File
                                        </a>
                                    </div>
                                @endif

                                {{-- VIDEO --}}
                                @if($content->type === 'video')
                                    <div class="mb-4">
                                        <h6 class="fw-semibold">{{ $content->title }}</h6>
                                        <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                                            <video controls class="w-100 h-100">
                                                <source src="{{ Storage::url($content->video_path) }}" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                @endif

                                {{-- QUIZ --}}
                                @if($content->type === 'quiz' && $content->quiz)
                                    <div class="mb-4">
                                        <h5 class="fw-semibold mb-2">
                                            Quiz: {{ $content->quiz->title }}
                                        </h5>
                                        @livewire('quiz-runner', [
                                            'quiz'   => $content->quiz,
                                            'lesson' => $currentLesson
                                        ], key('quiz-'.$content->id))
                                    </div>
                                @endif

                            @empty
                                <div class="alert alert-light border small">
                                    Tidak ada materi untuk lesson ini.
                                </div>
                            @endforelse

                            <hr>

                            {{-- ===== BUTTON MARK AS DONE ===== --}}
                            <form action="{{ route('student.lessons.mark-done', $currentLesson) }}"
                                  method="POST" class="mb-3">
                                @csrf
                                <button class="btn btn-success">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    Tandai Lesson Selesai
                                </button>
                            </form>

                            {{-- ===== NEXT / PREVIOUS ===== --}}
                            <div class="d-flex justify-content-between">
                                
                                {{-- PREVIOUS --}}
                                @php
                                    $prev = $course->getPrevLesson($currentLesson);
                                @endphp
                                @if($prev)
                                    <a class="btn btn-outline-secondary btn-sm"
                                       href="{{ route('student.courses.learn', [$course->id, 'lesson'=>$prev->id]) }}">
                                        <i class="bi bi-arrow-left me-1"></i> Sebelumnya
                                    </a>
                                @else
                                    <span></span>
                                @endif

                                {{-- NEXT --}}
                                @php
                                    $next = $course->getNextLesson($currentLesson);
                                @endphp
                                @if($next)
                                    <a class="btn btn-primary btn-sm"
                                       href="{{ route('student.courses.learn', [$course->id, 'lesson'=>$next->id]) }}">
                                        Selanjutnya <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                @endif

                            </div>

                        @else

                            {{-- ===== JIKA BELUM PILIH LESSON ===== --}}
                            <div class="text-center py-5">
                                <i class="bi bi-journal-bookmark fs-1 text-primary"></i>
                                <h5 class="mt-3 fw-semibold">Pilih Lesson untuk Mulai Belajar</h5>
                                <p class="text-muted small">Silakan pilih lesson dari sidebar kiri.</p>
                            </div>

                        @endisset

                    </div>
                </div>


                {{-- OPSIONAL: LIVE CHAT --}}
                @if(isset($enableChat) && $enableChat === true)
                    <div class="mt-3">
                        @livewire('course-chat', ['course_id' => $course->id])
                    </div>
                @endif

                {{-- OPSIONAL: DISCUSSION FORUM --}}
                @if(isset($enableDiscussion) && $enableDiscussion === true)
                    <div class="mt-3">
                        @livewire('course-discussion', ['course_id' => $course->id])
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
