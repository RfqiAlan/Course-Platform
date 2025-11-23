<x-app-layout title="Dashboard Student – EDVO">
    <div class="container py-4" data-aos="fade-up" data-aos-duration="600">
        {{-- Header --}}
        <div class="mb-3">
            <h1 class="h5 mb-1">Halo, {{ auth()->user()->name }}</h1>
            <p class="small text-muted mb-0">
                Selamat datang di dashboard belajar kamu. Lanjutkan course yang sedang berjalan
                atau mulai kelas baru.
            </p>
        </div>

        {{-- Stat cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden"
                     data-aos="fade-up" data-aos-duration="500" data-aos-delay="50">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted">Course Diikuti</span>
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                  style="width:32px;height:32px;background:#0F3D7315;">
                                <i class="bi bi-collection-play" style="color:#0F3D73;"></i>
                            </span>
                        </div>
                        <p class="fs-4 fw-semibold mb-0">{{ $enrolledCount ?? 0 }}</p>
                        <p class="small text-muted mb-0">Course yang sedang / pernah kamu ikuti.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden"
                     data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted">Course Selesai</span>
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                  style="width:32px;height:32px;background:rgba(16,185,129,0.08);">
                                <i class="bi bi-check2-circle text-success"></i>
                            </span>
                        </div>
                        <p class="fs-4 fw-semibold mb-0">{{ $completedCount ?? 0 }}</p>
                        <p class="small text-muted mb-0">Course yang sudah kamu tuntaskan.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden"
                     data-aos="fade-up" data-aos-duration="500" data-aos-delay="150">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted">Sertifikat</span>
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                  style="width:32px;height:32px;background:rgba(252,211,77,0.16);">
                                <i class="bi bi-award text-warning"></i>
                            </span>
                        </div>
                        <p class="fs-4 fw-semibold mb-0">{{ $certCount ?? 0 }}</p>
                        <p class="small text-muted mb-0">Sertifikat course yang sudah kamu dapatkan.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kursus yang sedang diikuti --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="h6 mb-0">Lanjutkan Belajar</h2>
            <a href="{{ route('student.courses.index') }}" class="small text-decoration-none"
               style="color:#0F3D73;">
                Lihat semua kursus &raquo;
            </a>
        </div>

        <div class="row g-3">
            @forelse($recentCourses ?? [] as $item)
                @php
                    $course = $item->course ?? $item; // tergantung struktur relasi kamu
                    $progress = $item->progress_percent ?? 0;
                @endphp
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100"
                         data-aos="fade-up" data-aos-duration="550" data-aos-delay="100">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-primary-subtle text-primary small mb-2">
                                {{ $course->category->name ?? 'Umum' }}
                            </span>
                            <h3 class="h6 mb-1 text-truncate">{{ $course->title }}</h3>
                            <p class="small text-muted mb-2">
                                <i class="bi bi-person-workspace me-1"></i>
                                {{ $course->teacher->name ?? 'Pengajar' }}
                            </p>

                            <div class="mb-2">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Progress</span>
                                    <span>{{ $progress }}%</span>
                                </div>
                                <div class="progress" style="height:6px;">
                                    <div class="progress-bar"
                                         style="width: {{ $progress }}%;background-color:#0F3D73;"></div>
                                </div>
                            </div>

                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <a href="{{ route('student.courses.learn',$course) }}"
                                   class="btn btn-sm text-white"
                                   style="background-color:#0F3D73;">
                                    <i class="bi bi-play-circle me-1"></i> Lanjutkan
                                </a>
                                <a href="{{ route('courses.show',$course) }}"
                                   class="small text-muted text-decoration-none">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12" data-aos="fade-up" data-aos-duration="550">
                    <div class="alert alert-light border small mb-0">
                        Kamu belum mengikuti course apa pun.
                        <a href="{{ route('courses.index') }}" class="text-decoration-none" style="color:#0F3D73;">
                            Jelajahi course sekarang
                        </a>.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
