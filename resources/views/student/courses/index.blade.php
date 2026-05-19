<x-app-layout title="Kursus Saya – EDVO">

    @push('styles')
    <style>
        .courses-hero-card {
            background: linear-gradient(135deg, #0F3D73, #2563eb);
            border-radius: 1.25rem;
            box-shadow: 0 18px 40px rgba(15, 61, 115, 0.25);
            color: #f9fafb;
        }
        .courses-hero-card h1 {
            font-size: 1.35rem;
            font-weight: 700;
        }
        .courses-hero-pill {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .12em;
            padding: .25rem .75rem;
            border-radius: 999px;
            background: rgba(15, 61, 115, 0.2);
            border: 1px solid rgba(209, 213, 219, 0.35);
        }
        .courses-hero-icon {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 61, 115, 0.18);
            backdrop-filter: blur(8px);
        }

        /* BOX / CARD KURSUS SAYA */
        .course-card {
            border-radius: 1.1rem;
            border: 1px solid #e5e7eb;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }
        .course-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(15, 23, 42, .12);
            border-color: rgba(37, 99, 235, 0.28);
        }
        .course-title {
            max-width: 260px;
        }
        .course-meta {
            font-size: .75rem;
            color: #9ca3af;
        }
        .course-desc {
            font-size: .8rem;
        }
        .course-footer-text {
            font-size: .8rem;
        }

        .progress-track {
            height: 6px;
            border-radius: 999px;
            background: #e5e7eb;
            overflow: hidden;
        }
        .progress-bar-brand {
            background: #0F3D73;
            height: 100%;
            transition: width .25s ease;
        }

        .badge-status {
            font-size: .7rem;
            border-radius: 999px;
            padding: .25rem .6rem;
            display: inline-flex;
            align-items: center;
            gap: .25rem;
        }
        .badge-status i {
            font-size: .85em;
        }
        .badge-status-done {
            background: #dcfce7;
            color: #166534;
        }
        .badge-status-learning {
            background: #e0ebff;
            color: #0F3D73;
        }
        .badge-status-not {
            background: #e5e7eb;
            color: #4b5563;
        }

        @media (max-width: 576px) {
            .courses-hero-card h1 {
                font-size: 1.1rem;
            }
        }
    </style>
    @endpush

    <div class="container py-4" data-aos="fade-up" data-aos-duration="600">
        <div class="mb-4">
            <div class="courses-hero-card p-3 p-md-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="courses-hero-icon">
                        <i class="bi bi-journal-check fs-5"></i>
                    </div>
                    <div>
                        <div class="courses-hero-pill mb-2">
                            Kursus Saya
                        </div>
                        <h1 class="mb-1">
                            Kursus yang kamu ikuti di EDVO.
                        </h1>
                        <p class="mb-0 small text-light" style="opacity:.92;">
                            Pantau progres belajar, lanjutkan kelas yang tertunda, dan unduh sertifikat
                            ketika course sudah tuntas.
                        </p>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-light text-primary-emphasis">
                        <i class="bi bi-search me-1"></i> Cari Course Lain
                    </a>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm rounded-4" data-aos="fade-up" data-aos-duration="550" data-aos-delay="80">
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success small mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h6 mb-0">Daftar Kursus</h2>
                    <span class="small text-muted">
                        Total: <strong>{{ $courses->count() }}</strong> kursus
                    </span>
                </div>
                <div class="row g-3">
                    @forelse($courses as $item)
                        @php
                            $course   = $item->course ?? $item; 
                            $progress = $item->progress_percent ?? ($item->pivot->progress ?? 0);
                            $isDone   = $item->is_completed ?? ($item->pivot->is_completed ?? false);
                        @endphp

                        <div class="col-md-6 col-lg-4">
                            <div class="card course-card h-100" data-aos="fade-up" data-aos-duration="550">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-light text-muted border">
                                            {{ $course->category->name ?? 'Umum' }}
                                        </span>

                                        @if($isDone)
                                            <span class="badge-status badge-status-done">
                                                <i class="bi bi-check-circle-fill"></i>
                                                Selesai
                                            </span>
                                        @elseif($progress > 0)
                                            <span class="badge-status badge-status-learning">
                                                <i class="bi bi-play-circle-fill"></i>
                                                Sedang dipelajari
                                            </span>
                                        @else
                                            <span class="badge-status badge-status-not">
                                                <i class="bi bi-dot"></i>
                                                Belum mulai
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="course-title mb-1 text-truncate" title="{{ $course->title }}">
                                        {{ $course->title }}
                                    </h3>
                                    <p class="small text-muted mb-2">
                                        <i class="bi bi-person-workspace me-1"></i>
                                        {{ $course->teacher->name ?? '-' }}
                                    </p>
                                    <p class="course-meta mb-3">
                                        <i class="bi bi-layers me-1"></i>
                                        {{ $course->modules->count() ?? 0 }} modul
                                        <span class="mx-1">•</span>
                                        <i class="bi bi-people me-1"></i>
                                        {{ $course->students->count() ?? 0 }} siswa
                                    </p>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="text-muted small">Progres</span>
                                            <span class="fw-semibold small">{{ $progress }}%</span>
                                        </div>
                                        <div class="progress-track">
                                            <div class="progress-bar-brand" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                    <div class="mt-auto d-flex justify-content-between align-items-center course-footer-text">
                                        <span class="text-muted">
                                            @if($isDone)
                                                <i class="bi bi-award me-1 text-success"></i>
                                                Siap unduh sertifikat
                                            @elseif($progress > 0)
                                                <i class="bi bi-clock-history me-1"></i>
                                                Lanjutkan belajar
                                            @else
                                                <i class="bi bi-play-circle me-1"></i>
                                                Mulai sekarang
                                            @endif
                                        </span>

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('student.courses.learn',$course) }}"
                                               class="btn btn-primary">
                                                <i class="bi bi-play-circle me-1"></i> Belajar
                                            </a>
                                            @if($isDone)
                                                <a href="{{ route('student.certificates.index') }}"
                                                   class="btn btn-outline-success">
                                                    <i class="bi bi-award me-1"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-light border text-center py-4">
                                <div class="mb-2">
                                    <i class="bi bi-emoji-neutral fs-3 d-block mb-1"></i>
                                    Belum ada course yang kamu ikuti.
                                </div>
                                <a href="{{ route('courses.index') }}" class="btn btn-sm btn-primary">
                                    Mulai cari course di sini
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($courses instanceof \Illuminate\Pagination\AbstractPaginator)
                    <div class="mt-3">
                        {{ $courses->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
