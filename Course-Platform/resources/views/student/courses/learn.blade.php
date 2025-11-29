<x-app-layout :title="'Belajar: ' . $course->title">
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
                                            $active    = isset($currentLesson) && $l->id === $currentLesson->id;
                                            $isDone    = isset($doneLessonIds) && in_array($l->id, $doneLessonIds);
                                            $canAccess = isset($allowedLessonIds) && in_array($l->id, $allowedLessonIds);
                                        @endphp

                                        <li class="mb-1">
                                            @if($canAccess)
                                                {{-- BISA DIKLIK --}}
                                                <a href="{{ route('student.courses.learn', [
                                                        'course' => $course->id,
                                                        'lesson' => $l->id
                                                    ]) }}"
                                                   class="d-flex align-items-center p-2 rounded-3 small
                                                       @if($active)
                                                           bg-primary text-white fw-semibold
                                                       @elseif($isDone)
                                                           bg-success-subtle text-success border border-success
                                                       @else
                                                           bg-light text-dark
                                                       @endif"
                                                   style="text-decoration:none; border-left: 4px solid {{ $isDone ? '#198754' : 'transparent' }};">

                                                    @if($isDone)
                                                        <span class="me-2 rounded-circle"
                                                              style="width:8px; height:8px; background-color:#198754;"></span>
                                                    @else
                                                        <span class="me-2" style="width:8px; height:8px;"></span>
                                                    @endif

                                                    <i class="bi bi-play-circle me-2"></i>
                                                    <span class="text-truncate">{{ $l->title }}</span>
                                                </a>
                                            @else
                                                {{-- TERKUNCI --}}
                                                <div class="d-flex align-items-center p-2 rounded-3 small bg-light text-muted opacity-75"
                                                     style="border-left: 4px solid transparent; cursor:not-allowed;">
                                                    <span class="me-2" style="width:8px; height:8px;"></span>
                                                    <i class="bi bi-lock-fill me-2"></i>
                                                    <span class="text-truncate">{{ $l->title }}</span>
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ========================= --}}
            {{-- KONTEN UTAMA (LESSON + CHAT) --}}
            {{-- ========================= --}}
            <div class="col-lg-9">
                {{-- CARD KONTEN LESSON --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">

                        @isset($currentLesson)

                            @php
                                $currentIsDone = isset($doneLessonIds) && in_array($currentLesson->id, $doneLessonIds);
                            @endphp

                            {{-- ===== HEADER LESSON ===== --}}
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="small text-muted mb-1">
                                        Lesson {{ $currentLesson->order }}
                                    </p>
                                    <h4 class="fw-bold mb-1">{{ $currentLesson->title }}</h4>
                                    <p class="text-muted small mb-1">{{ $currentLesson->summary }}</p>

                                    @if($currentIsDone)
                                        <span class="badge bg-success-subtle text-success small mt-1">
                                            <i class="bi bi-check2-circle me-1"></i> Sudah ditandai selesai
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning small mt-1">
                                            <i class="bi bi-hourglass-split me-1"></i> Belum selesai
                                        </span>
                                    @endif
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

                                {{-- FILE (dokumen / gambar) --}}
                                @if($content->type === 'file')
                                    @php
                                        $extension = $content->file_path
                                            ? strtolower(pathinfo($content->file_path, PATHINFO_EXTENSION))
                                            : null;
                                        $isImage = in_array($extension, ['jpg','jpeg','png','webp']);
                                    @endphp

                                    @if($isImage)
                                        <div class="mb-4">
                                            @if($content->title)
                                                <h6 class="fw-semibold mb-2">{{ $content->title }}</h6>
                                            @endif

                                            @if($content->file_path)
                                                <img src="{{ route('student.contents.image', $content) }}"
                                                     alt="{{ $content->title ?? 'Gambar materi' }}"
                                                     class="img-fluid rounded-3 border mb-2">
                                            @else
                                                <p class="small text-danger mb-0">Gambar belum tersedia.</p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="mb-4">
                                            @if($content->title)
                                                <h6 class="fw-semibold mb-2">{{ $content->title }}</h6>
                                            @endif

                                            @if($content->file_path)
                                                <a href="{{ route('student.contents.download', $content) }}"
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-file-earmark-arrow-down me-1"></i>
                                                    Unduh File
                                                </a>
                                            @else
                                                <p class="small text-danger mb-0">File belum tersedia.</p>
                                            @endif
                                        </div>
                                    @endif
                                @endif

                                {{-- VIDEO --}}
                                @if($content->type === 'video')
                                    <div class="mb-4">
                                        @if($content->title)
                                            <h6 class="fw-semibold mb-2">{{ $content->title }}</h6>
                                        @endif

                                        @if($content->video_path)
                                            <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                                                <video controls class="w-100 h-100">
                                                    <source src="{{ route('student.contents.stream', $content) }}" type="video/mp4">
                                                    Browser Anda tidak mendukung pemutar video.
                                                </video>
                                            </div>
                                        @else
                                            <p class="small text-danger mb-0">Video belum tersedia.</p>
                                        @endif
                                    </div>
                                @endif

                            @empty
                                <div class="alert alert-light border small">
                                    Tidak ada materi untuk lesson ini.
                                </div>
                            @endforelse

                            <hr>

                            {{-- ===== BUTTON MARK AS DONE ===== --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <form action="{{ route('student.lessons.mark-done', $currentLesson) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm" @if($currentIsDone) disabled @endif>
                                            <i class="bi bi-check2-circle me-1"></i>
                                            @if($currentIsDone)
                                                Sudah Ditandai Selesai
                                            @else
                                                Tandai Lesson Selesai
                                            @endif
                                        </button>
                                    </form>
                                    @if(!$currentIsDone)
                                        <p class="small text-muted mb-0 mt-1">
                                            Tandai selesai dulu untuk membuka tombol <strong>Selanjutnya</strong> dan lesson berikutnya.
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- ===== NEXT / PREVIOUS ===== --}}
                            <div class="d-flex justify-content-between">
                                {{-- PREVIOUS --}}
                                @php
                                    $prev = $course->getPrevLesson($currentLesson);
                                @endphp
                                @if($prev)
                                    <a class="btn btn-outline-secondary btn-sm"
                                       href="{{ route('student.courses.learn', [
                                            'course' => $course->id,
                                            'lesson' => $prev->id
                                       ]) }}">
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
                                    @if($currentIsDone)
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('student.courses.learn', [
                                                'course' => $course->id,
                                                'lesson' => $next->id
                                           ]) }}">
                                            Selanjutnya <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-primary btn-sm" disabled>
                                            Selanjutnya <i class="bi bi-lock ms-1"></i>
                                        </button>
                                    @endif
                                @endif
                            </div>

                        @else
                            {{-- JIKA BELUM PILIH LESSON --}}
                            <div class="text-center py-5">
                                <i class="bi bi-journal-bookmark fs-1 text-primary"></i>
                                <h5 class="mt-3 fw-semibold">Pilih Lesson untuk Mulai Belajar</h5>
                                <p class="text-muted small">Silakan pilih lesson dari sidebar kiri.</p>
                            </div>
                        @endisset

                    </div>
                </div>

                {{-- LIVE CHAT --}}
                <div class="row g-3 mt-3">
                    <div class="col-lg-6">
                        {{-- ⬇️ kirim juga $discussions ke komponen --}}
                        @include('components.course-discussion-box', [
                            'course' => $course,
                            'discussions' => $discussions ?? [],
                        ])
                    </div>
                    <div class="col-lg-6">
                        @include('components.private-chat-box', ['course' => $course])
                    </div>
                </div>

            </div> {{-- /col-lg-9 --}}
        </div>
    </div>
</x-app-layout>
