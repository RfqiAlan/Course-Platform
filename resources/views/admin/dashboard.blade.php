<x-admin-layout title="Dashboard">
    @push('styles')
        <style>
            .stat-card {
                border-radius: 1rem;
                border: none;
                box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
                overflow: hidden;
                position: relative;
                transition: all 0.2s ease;
            }
            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 30px rgba(15, 23, 42, 0.12);
            }

            .stat-icon {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
            }

            .stat-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
            .stat-icon.green { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
            .stat-icon.purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
            .stat-icon.orange { background: rgba(249, 115, 22, 0.1); color: #f97316; }

            .welcome-card {
                background: linear-gradient(135deg, #0F3D73 0%, #1e40af 100%);
                border-radius: 1rem;
                color: #fff;
                position: relative;
                overflow: hidden;
            }
            .welcome-card::before {
                content: "";
                position: absolute;
                top: -50%;
                right: -20%;
                width: 300px;
                height: 300px;
                background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 60%);
            }

            .table-dashboard thead th {
                background: #f8fafc;
                border-bottom-width: 0;
                font-size: .75rem;
                text-transform: uppercase;
                letter-spacing: .05em;
                color: #64748b;
                font-weight: 600;
            }
            .table-dashboard tbody tr {
                transition: background-color .15s ease;
            }
            .table-dashboard tbody tr:hover {
                background-color: #f8fafc;
            }
        </style>
    @endpush

    <div data-aos="fade-up" data-aos-duration="600">
        <!-- Welcome Card -->
        <div class="welcome-card p-4 mb-4">
            <div class="row align-items-center position-relative" style="z-index:1;">
                <div class="col-lg-8">
                    <h4 class="fw-bold mb-2">
                        Selamat datang, {{ auth()->user()->name }}! 👋
                    </h4>
                    <p class="mb-0 small opacity-75">
                        Kelola course, kategori, dan pengguna dalam satu tempat. Pantau aktivitas platform EDVO dengan mudah.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Course
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small mb-1">Total Pengguna</p>
                                <h3 class="fw-bold mb-0">{{ $totalUsers ?? 0 }}</h3>
                                <p class="text-muted small mb-0 mt-1">
                                    {{ $totalAdmins ?? 0 }} Admin, {{ $totalTeachers ?? 0 }} Teacher, {{ $totalStudents ?? 0 }} Student
                                </p>
                            </div>
                            <div class="stat-icon blue">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small mb-1">Total Kursus</p>
                                <h3 class="fw-bold mb-0">{{ $totalCourses ?? 0 }}</h3>
                                <p class="text-muted small mb-0 mt-1">{{ $totalCategories ?? 0 }} Kategori</p>
                            </div>
                            <div class="stat-icon purple">
                                <i class="bi bi-journal-bookmark-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small mb-1">Enrollments</p>
                                <h3 class="fw-bold mb-0">{{ $totalEnrollments ?? 0 }}</h3>
                                <p class="text-muted small mb-0 mt-1">Pendaftaran aktif</p>
                            </div>
                            <div class="stat-icon green">
                                <i class="bi bi-clipboard-check-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small mb-1">Sertifikat</p>
                                <h3 class="fw-bold mb-0">{{ $totalCertificates ?? 0 }}</h3>
                                <p class="text-muted small mb-0 mt-1">Terbit</p>
                            </div>
                            <div class="stat-icon orange">
                                <i class="bi bi-award-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="row g-3 mt-1">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">Kursus Terbaru</h6>
                            <a href="{{ route('admin.courses.index') }}" class="small text-decoration-none text-primary">
                                Lihat semua <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
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
                                            <div class="fw-semibold text-truncate" style="max-width:200px;">
                                                {{ $course->title }}
                                            </div>
                                            <div class="small text-muted">
                                                {{ $course->created_at?->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-muted">
                                                {{ $course->category->name ?? 'Umum' }}
                                            </span>
                                        </td>
                                        <td class="small">
                                            {{ $course->teacher->name ?? '-' }}
                                        </td>
                                        <td class="text-end small">
                                            {{ $course->students_count ?? $course->students->count() ?? 0 }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4 small">
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
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">User Terbaru</h6>
                            <a href="{{ route('admin.users.index') }}" class="small text-decoration-none text-primary">
                                Kelola user <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <ul class="list-group list-group-flush small">
                            @forelse($recentUsers ?? [] as $user)
                                <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <span class="badge bg-light text-muted" style="font-size: 0.65rem;">
                                                {{ strtoupper($user->role) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="small text-muted">{{ $user->created_at?->diffForHumans() }}</span>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item px-0 text-muted text-center py-4 small">
                                    Belum ada user baru.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
