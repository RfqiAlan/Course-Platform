<x-app-layout title="Dashboard Admin – EDVO">
    @push('styles')
        <style>
            .admin-hero-card {
                background: radial-gradient(circle at top left, #1d4ed8 0, #0F3D73 38%, #020617 100%);
                border-radius: 1.5rem;
                color: #e5e7eb;
                box-shadow: 0 22px 55px rgba(15, 23, 42, 0.65);
                position: relative;
                overflow: hidden;
            }
            .admin-hero-card::after {
                content: "";
                position: absolute;
                inset: auto -40px -80px auto;
                width: 260px;
                height: 260px;
                background: radial-gradient(circle, rgba(59,130,246,0.36), transparent 60%);
                opacity: .9;
            }

            .admin-hero-badge {
                font-size: .7rem;
                text-transform: uppercase;
                letter-spacing: .16em;
                border-radius: 999px;
                padding: .25rem .9rem;
                background: rgba(15, 23, 42, 0.4);
                border: 1px solid rgba(148, 163, 184, 0.6);
                color: #e5e7eb;
            }
            .admin-hero-title {
                font-size: 1.5rem;
                font-weight: 700;
            }
            @media (min-width: 992px) {
                .admin-hero-title {
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

            .mini-chip {
                font-size: .7rem;
                border-radius: 999px;
                padding: .15rem .5rem;
                background: #f3f4ff;
                color: #4b5563;
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

            .badge-pill-soft {
                border-radius: 999px;
                font-size: .7rem;
                padding: .18rem .55rem;
            }
        </style>
    @endpush

    <div class="container py-4" data-aos="fade-up" data-aos-duration="600">
        <div class="admin-hero-card p-4 p-md-5 mb-4">
            <div class="row align-items-center g-4 position-relative" style="z-index:1;">
                <div class="col-lg-8">
                    <div class="admin-hero-badge mb-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Dashboard Admin</span>
                    </div>
                    <h1 class="admin-hero-title mb-2">
                        Halo, {{ auth()->user()->name }} 👋
                    </h1>
                    <p class="mb-3 small" style="max-width: 520px; opacity:.92;">
                        Kelola course, kategori, dan pengguna dalam satu tempat.
                        Pantau aktivitas terbaru dan pastikan semua proses belajar
                        di EDVO berjalan dengan lancar.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="mini-chip">
                            <i class="bi bi-book-half me-1"></i>
                            {{ $totalCourses ?? 0 }} Course aktif
                        </span>
                        <span class="mini-chip">
                            <i class="bi bi-people me-1"></i>
                            {{ $totalUsers ?? 0 }} Pengguna terdaftar
                        </span>
                        <span class="mini-chip">
                            <i class="bi bi-award me-1"></i>
                            {{ $totalCertificates ?? 0 }} Sertifikat terbit
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-flex flex-column gap-2 align-items-lg-end">
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-light text-primary-emphasis">
                            <i class="bi bi-journal-text me-1"></i> Kelola Course
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-light text-white border-light">
                            <i class="bi bi-people me-1"></i> Manajemen User
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card stat-card h-100" data-aos="fade-up" data-aos-duration="500" data-aos-delay="50">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Total User</span>
                            <div class="stat-icon">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                        <p class="fs-4 fw-semibold mb-1">{{ $totalUsers ?? 0 }}</p>
                        <p class="small text-muted mb-0">
                            Admin: {{ $totalAdmins ?? 0 }} • Teacher: {{ $totalTeachers ?? 0 }} • Student: {{ $totalStudents ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card h-100" data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Total Course</span>
                            <div class="stat-icon">
                                <i class="bi bi-journal-bookmark"></i>
                            </div>
                        </div>
                        <p class="fs-4 fw-semibold mb-1">{{ $totalCourses ?? 0 }}</p>
                        <p class="small text-muted mb-0">
                            Kategori: {{ $totalCategories ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card h-100" data-aos="fade-up" data-aos-duration="500" data-aos-delay="150">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Enrollments</span>
                            <div class="stat-icon">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                        </div>
                        <p class="fs-4 fw-semibold mb-1">{{ $totalEnrollments ?? 0 }}</p>
                        <p class="small text-muted mb-0">
                            Total pendaftaran course oleh student.
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
                            Course yang sudah diselesaikan student.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100"
                     data-aos="fade-up" data-aos-duration="550" data-aos-delay="80">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h2 class="h6 mb-0">Course terbaru</h2>
                            <a href="{{ route('admin.courses.index') }}" class="small text-decoration-none" style="color:#0F3D73;">
                                Lihat semua &raquo;
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0 table-dashboard">
                                <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Kategori</th>
                                    <th>Pengajar</th>
                                    <th class="text-end">Siswa</th>
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
                                            <i class="bi bi-person-workspace me-1 text-muted"></i>
                                            {{ $course->teacher->name ?? '-' }}
                                        </td>
                                        <td class="text-end small">
                                            <i class="bi bi-people me-1 text-muted"></i>
                                            {{ $course->students_count ?? $course->students->count() ?? 0 }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3 small">
                                            Belum ada course yang terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100"
                     data-aos="fade-up" data-aos-duration="550" data-aos-delay="120">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h2 class="h6 mb-0">User terbaru</h2>
                            <a href="{{ route('admin.users.index') }}" class="small text-decoration-none" style="color:#0F3D73;">
                                Kelola user &raquo;
                            </a>
                        </div>

                        <ul class="list-group list-group-flush small">
                            @forelse($recentUsers ?? [] as $user)
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-muted">
                                            <span class="badge badge-pill-soft bg-light border text-muted me-1">
                                                {{ strtoupper($user->role) }}
                                            </span>
                                            <span class="small">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $user->created_at?->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="small text-muted d-block">
                                            {{ $user->email }}
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item px-0 text-muted text-center small">
                                    Belum ada user baru.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
