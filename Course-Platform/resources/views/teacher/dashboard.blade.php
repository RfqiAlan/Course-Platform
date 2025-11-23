<x-app-layout title="Dashboard Teacher – EDVO">
    @push('styles')
        <style>
            .teacher-hero-card {
                background: radial-gradient(circle at top left, #38bdf8 0, #0F3D73 40%, #020617 100%);
                border-radius: 1.5rem;
                color: #e5e7eb;
                box-shadow: 0 22px 55px rgba(15, 23, 42, 0.6);
                position: relative;
                overflow: hidden;
            }
            .teacher-hero-card::after {
                content: "";
                position: absolute;
                inset: auto -40px -80px auto;
                width: 240px;
                height: 240px;
                background: radial-gradient(circle, rgba(56,189,248,0.35), transparent 60%);
                opacity: .9;
            }
            .teacher-hero-badge {
                font-size: .7rem;
                text-transform: uppercase;
                letter-spacing: .16em;
                border-radius: 999px;
                padding: .25rem .9rem;
                background: rgba(15, 23, 42, 0.4);
                border: 1px solid rgba(148, 163, 184, 0.5);
                color: #e5e7eb;
            }
            .teacher-hero-title {
                font-size: 1.5rem;
                font-weight: 700;
            }
            @media (min-width: 992px) {
                .teacher-hero-title {
                    font-size: 1.8rem;
                }
            }

            .stat-card {
                border-radius: 1.1rem;
                border: none;
                box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
                overflow: hidden;
                position: relative;
            }
            .stat-card::before {
                content: "";
                position: absolute;
                inset: 0;
                opacity: 0;
                background: linear-gradient(135deg, rgba(15,61,115,.08), transparent);
                transition: opacity .2s ease;
            }
            .stat-card:hover::before {
                opacity: 1;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                border-radius: 999px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: rgba(15,61,115,0.06);
                color: #0F3D73;
            }

            .badge-pill-soft {
                border-radius: 999px;
                font-size: .7rem;
                padding: .18rem .55rem;
            }

            .table-dashboard thead th {
                background: #f3f4ff;
                border-bottom-width: 0;
                font-size: .75rem;
                text-transform: uppercase;
                letter-spacing: .08em;
                color: #6b7280;
            }
            .table-dashboard tbody tr {
                transition: background-color .16s ease, transform .12s ease;
            }
            .table-dashboard tbody tr:hover {
                background-color: #f9fafb;
                transform: translateY(-1px);
            }
        </style>
    @endpush

    <div class="container py-4" data-aos="fade-up" data-aos-duration="600">
        {{-- HERO TEACHER --}}
        <div class="teacher-hero-card p-4 p-md-5 mb-4">
            <div class="row align-items-center g-4 position-relative" style="z-index:1;">
                <div class="col-lg-8">
                    <div class="teacher-hero-badge mb-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-person-workspace"></i>
                        <span>Dashboard Teacher</span>
                    </div>
                    <h1 class="teacher-hero-title mb-2">
                        Halo, {{ auth()->user()->name }} 👋
                    </h1>
                    <p class="mb-3 small" style="max-width: 520px; opacity:.92;">
                        Pantau performa kelas yang kamu ajar, jumlah siswa, dan progress belajar mereka.
                        Atur materi dan modul dengan lebih terstruktur di EDVO.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('teacher.courses.create') }}" class="btn btn-sm btn-light text-primary-emphasis">
                            <i class="bi bi-plus-circle me-1"></i> Buat Course Baru
                        </a>
                        <a href="{{ route('teacher.courses.index') }}" class="btn btn-sm btn-outline-light text-white border-light">
                            <i class="bi bi-journal-text me-1"></i> Kelola Semua Course
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-flex flex-column gap-2 align-items-lg-end">
                        <span class="badge-pill-soft bg-light text-muted border">
                            <i class="bi bi-book-half me-1 text-primary"></i>
                            {{ $totalCourses ?? 0 }} course aktif
                        </span>
                        <span class="badge-pill-soft bg-light text-muted border">
                            <i class="bi bi-people me-1 text-primary"></i>
                            {{ $totalStudents ?? 0 }} siswa unik
                        </span>
                        <span class="badge-pill-soft bg-light text-muted border">
                            <i class="bi bi-award me-1 text-primary"></i>
                            {{ $totalCertificates ?? 0 }} sertifikat terbit
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- STAT KECIL --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card stat-card h-100" data-aos="fade-up" data-aos-duration="500" data-aos-delay="50">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Course Aktif</span>
                            <div class="stat-icon">
                                <i class="bi bi-journal-bookmark"></i>
                            </div>
                        </div>
                        <p class="fs-4 fw-semibold mb-1">{{ $totalCourses ?? 0 }}</p>
                        <p class="small text-muted mb-0">
                            Course yang kamu ajar saat ini.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card h-100" data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Total Modul</span>
                            <div class="stat-icon">
                                <i class="bi bi-layers"></i>
                            </div>
                        </div>
                        <p class="fs-4 fw-semibold mb-1">{{ $totalModules ?? 0 }}</p>
                        <p class="small text-muted mb-0">
                            Rata-rata {{ $avgModulesPerCourse ?? 0 }} modul / course.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card h-100" data-aos="fade-up" data-aos-duration="500" data-aos-delay="150">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Total Lesson</span>
                            <div class="stat-icon">
                                <i class="bi bi-collection-play"></i>
                            </div>
                        </div>
                        <p class="fs-4 fw-semibold mb-1">{{ $totalLessons ?? 0 }}</p>
                        <p class="small text-muted mb-0">
                            Materi yang sudah kamu siapkan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card h-100" data-aos="fade-up" data-aos-duration="500" data-aos-delay="200">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Sertifikat Terbit</span>
                            <div class="stat-icon">
                                <i class="bi bi-award"></i>
                            </div>
                        </div>
                        <p class="fs-4 fw-semibold mb-1">{{ $totalCertificates ?? 0 }}</p>
                        <p class="small text-muted mb-0">
                            Dari siswa yang menuntaskan course kamu.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- COURSE DIBUAT TEACHER --}}
        <div class="row g-3">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100"
                     data-aos="fade-up" data-aos-duration="550" data-aos-delay="80">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h2 class="h6 mb-0">Course yang kamu ajar</h2>
                            <a href="{{ route('teacher.courses.index') }}" class="small text-decoration-none" style="color:#0F3D73;">
                                Lihat semua &raquo;
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0 table-dashboard">
                                <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Kategori</th>
                                    <th>Siswa</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($recentCourses ?? [] as $course)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-truncate" style="max-width:220px;">
                                                {{ $course->title }}
                                            </div>
                                            <div class="small text-muted">
                                                <i class="bi bi-clock-history me-1"></i>
                                                {{ $course->created_at?->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill-soft bg-light text-muted border">
                                                {{ $course->category->name ?? 'Umum' }}
                                            </span>
                                        </td>
                                        <td class="small">
                                            <i class="bi bi-people me-1 text-muted"></i>
                                            {{ $course->students_count ?? $course->students->count() ?? 0 }}
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('teacher.courses.edit', $course) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil-square me-1"></i>Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3 small">
                                            Kamu belum membuat course apa pun.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RINGKASAN SISWA / AKTIVITAS --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100"
                     data-aos="fade-up" data-aos-duration="550" data-aos-delay="120">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h2 class="h6 mb-0">Ringkasan siswa</h2>
                        </div>

                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Total siswa unik</span>
                                <span class="fw-semibold">{{ $totalStudents ?? 0 }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Rata-rata siswa / course</span>
                                <span class="fw-semibold">{{ $avgStudentsPerCourse ?? 0 }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Total enrollment</span>
                                <span class="fw-semibold">{{ $totalEnrollments ?? 0 }}</span>
                            </li>
                        </ul>

                        <hr class="my-3">

                        <p class="small text-muted mb-2">
                            Tips: terus update materi dan tambah quiz / latihan
                            agar siswa tetap aktif dan progress belajar meningkat.
                        </p>
                        <a href="{{ route('teacher.courses.create') }}"
                           class="btn btn-sm btn-primary">
                            <i class="bi bi-lightning-charge me-1"></i> Buat materi baru sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
