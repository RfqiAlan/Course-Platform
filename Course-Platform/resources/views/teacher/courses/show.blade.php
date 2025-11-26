{{-- resources/views/teacher/courses/show.blade.php --}}

<x-app-layout :title="$course->title.' – Panel Pengajar'">
    <div class="container py-4">
        <div class="row g-4">
            {{-- KIRI: INFO COURSE & KURIKULUM --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body">
                        <span class="badge bg-primary-subtle text-primary small mb-2">
                            {{ $course->category->name ?? 'Tanpa Kategori' }}
                        </span>
                        <h1 class="h4 mb-1">{{ $course->title }}</h1>
                        <p class="small text-muted mb-2">
                            <i class="bi bi-person-workspace me-1"></i>
                            Pengajar: {{ $course->teacher->name ?? 'Pengajar' }}
                        </p>
                        <p class="text-muted mb-0" style="white-space:pre-line">
                            {{ $course->description }}
                        </p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Kurikulum Kursus</h2>
                        @forelse($course->modules as $module)
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <div class="badge rounded-pill text-bg-primary me-2">
                                        Modul {{ $loop->iteration }}
                                    </div>
                                    <span class="fw-semibold">{{ $module->title }}</span>
                                </div>
                                <ul class="list-unstyled ms-4 small text-muted mb-1">
                                    @foreach($module->lessons as $lesson)
                                        <li class="d-flex align-items-center mb-1">
                                            <i class="bi bi-play-circle me-2 text-primary"></i>
                                            <span>{{ $lesson->title }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @empty
                            <p class="small text-muted mb-0">Belum ada modul tersusun.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- KANAN: PANEL GURU + CHAT KELAS --}}
            <div class="col-lg-4">
                {{-- Statistik singkat --}}
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Panel Pengajar</h2>

                        <p class="small mb-1 text-muted">
                            <i class="bi bi-people me-1 text-primary"></i>
                            {{ $course->students()->count() }} siswa terdaftar
                        </p>
                        <p class="small mb-1 text-muted">
                            <i class="bi bi-clock-history me-1 text-primary"></i>
                            {{ $course->modules->sum(fn($m) => $m->lessons->count()) }} lesson
                        </p>
                        <p class="small mb-0 text-muted">
                            <i class="bi bi-chat-dots me-1 text-primary"></i>
                            Diskusi kelas aktif untuk course ini.
                        </p>
                    </div>
                </div>
                @include('components.course-discussion-box', ['course' => $course])
            </div>
        </div>
    </div>
</x-app-layout>
