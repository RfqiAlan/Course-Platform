<x-app-layout title="Dashboard Student – LearnHub">
    <div class="container py-4">
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
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted">Course Diikuti</span>
                            <i class="bi bi-collection-play text-primary"></i>
                        </div>
                        <p class="fs-4 fw-semibold mb-0">{{ $enrolledCount ?? 0 }}</p>
                        <p class="small text-muted mb-0">Course yang sedang / pernah kamu ikuti.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted">Course Selesai</span>
                            <i class="bi bi-check2-circle text-success"></i>
                        </div>
                        <p class="fs-4 fw-semibold mb-0">{{ $completedCount ?? 0 }}</p>
                        <p class="small text-muted mb-0">Course yang sudah kamu tuntaskan.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted">Sertifikat</span>
                            <i class="bi bi-award text-warning"></i>
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
            <a href="{{ route('student.courses.index') }}" class="small">
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
                    <div class="card border-0 shadow-sm rounded-4 h-100">
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
                                    <div class="progress-bar bg-primary"
                                         style="width: {{ $progress }}%"></div>
                                </div>
                            </div>

                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <a href="{{ route('student.courses.learn',$course) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-play-circle me-1"></i> Lanjutkan
                                </a>
                                <a href="{{ route('courses.show',$course) }}"
                                   class="small text-muted">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border small mb-0">
                        Kamu belum mengikuti course apa pun.  
                        <a href="{{ route('courses.index') }}">Jelajahi course sekarang</a>.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
