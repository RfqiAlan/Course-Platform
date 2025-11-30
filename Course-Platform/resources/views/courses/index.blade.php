@push('styles')
<style>
    .catalog-hero-card {
        background: #ffffffee;
        backdrop-filter: blur(10px);
        border-radius: 24px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.18);
    }
    .catalog-hero-tag {
        font-size: .8rem;
        letter-spacing: .08em;
        text-transform: uppercase;
    }
    .catalog-hero-title {
        font-size: 2.1rem;
    }
    @media (min-width: 992px) {
        .catalog-hero-title {
            font-size: 2.4rem;
        }
    }

    .catalog-stat-number {
        font-weight: 700;
        font-size: 1.3rem;
    }

    .course-card {
        border-radius: 18px;
        border: 0;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
        transition: transform .18s ease, box-shadow .18s ease;
    }
    .course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(15, 23, 42, .16);
    }
    .course-thumb {
        background: linear-gradient(135deg, #0F3D73, #2563eb);
        position: relative;
    }
    .course-thumb-badge {
        position: absolute;
        left: 12px;
        bottom: 10px;
        background: #ffffffee;
        color: #0F3D73;
        border-radius: 999px;
        font-size: .7rem;
        padding: .18rem .65rem;
    }
    .course-title {
        font-size: .98rem;
        font-weight: 600;
    }
    .course-desc {
        font-size: .8rem;
        min-height: 2.6em;
    }
    .course-footer-text {
        font-size: .78rem;
    }
</style>
@endpush

<x-app-layout title="Katalog Kursus – EDVO">
    <div class="container py-4">

        <section class="pb-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7" data-aos="fade-right" data-aos-duration="650">
                    <div class="catalog-hero-card p-4 p-lg-5">
                        <div class="badge rounded-pill px-3 py-2 mb-3 catalog-hero-tag"
                             style="background:#EAF2FF;color:#0F3D73;">
                            Katalog Kursus EDVO
                        </div>

                        <h1 class="fw-bold mb-3 catalog-hero-title">
                            Temukan Kursus Terbaik<br>
                            untuk Perjalanan Belajarmu.
                        </h1>

                        <p class="text-muted mb-4">
                            Jelajahi ratusan kursus dari berbagai kategori. Gunakan filter untuk mencari
                            berdasarkan kategori, pengajar, dan minat belajarmu. Mulai dari basic sampai level lanjut.
                        </p>

                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <a href="#course-list" class="btn btn-primary btn-lg px-4"
                               style="background:#0F3D73;border-color:#0F3D73;">
                                <i class="bi bi-search me-2"></i> Cari Kursus
                            </a>

                            @auth
                                @if(auth()->user()->isStudent())
                                    <a href="{{ route('student.courses.index') }}?my=1"
                                       class="btn btn-outline-primary btn-lg px-4"
                                       style="border-color:#0F3D73;color:#0F3D73;">
                                        Kursus Saya
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   class="btn btn-outline-primary btn-lg px-4"
                                   style="border-color:#0F3D73;color:#0F3D73;">
                                    Masuk untuk mulai belajar
                                </a>
                            @endauth
                        </div>

                        <div class="d-flex flex-wrap gap-4">
                            <div>
                                <div class="catalog-stat-number" style="color:#FFC400;">
                                    {{ $courses->total() ?? $courses->count() }}+
                                </div>
                                <div class="text-muted small">Kursus aktif</div>
                            </div>
                            @if(!empty($categories))
                                <div>
                                    <div class="catalog-stat-number" style="color:#3396FF;">
                                        {{ count($categories) }}+
                                    </div>
                                    <div class="text-muted small">Kategori belajar</div>
                                </div>
                            @endif
                            <div>
                                <div class="catalog-stat-number" style="color:#FF5E5E;">
                                    3
                                </div>
                                <div class="text-muted small">Level: Basic–Advanced</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left" data-aos-duration="650">
                    <div class="position-relative">
                        <div class="rounded-circle"
                             style="width:260px;height:260px;background:#FF7A39;position:absolute;right:0;top:18%;z-index:1;opacity:.9;">
                        </div>

                        <div class="card border-0 shadow-lg rounded-4 position-relative" style="z-index:2;">
                            <div class="card-body p-3 p-lg-4">
                                <p class="small text-muted mb-2">Kenapa belajar di EDVO?</p>
                                <ul class="list-unstyled small mb-0">
                                    <li class="mb-1">
                                        <i class="bi bi-check2-circle text-success me-2"></i>
                                        Struktur rapi: Course → Modul → Lesson → Konten.
                                    </li>
                                    <li class="mb-1">
                                        <i class="bi bi-check2-circle text-success me-2"></i>
                                        Monitoring progress belajar dan sertifikat digital.
                                    </li>
                                    <li class="mb-1">
                                        <i class="bi bi-check2-circle text-success me-2"></i>
                                        Forum diskusi untuk tanya jawab dengan pengajar.
                                    </li>
                                    <li class="mb-1">
                                        <i class="bi bi-check2-circle text-success me-2"></i>
                                        Tampilan sederhana & ringan untuk kebutuhan kampus.
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="rounded-circle"
                             style="width:110px;height:110px;background:#FFD955;position:absolute;left:0;bottom:-8%;z-index:0;">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="course-list" class="pb-4" data-aos="fade-up" data-aos-duration="600">
            <div class="mb-3 p-3 p-md-3 rounded-4 bg-white shadow-sm d-flex flex-wrap justify-content-between align-items-center gap-3">
                <h2 class="h6 mb-0">Daftar Kursus</h2>

                <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    <div class="input-group input-group-sm" style="max-width:260px">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0"
                               name="q" value="{{ request('q') }}" placeholder="Cari judul / pengajar">
                    </div>

                    <select name="category" class="form-select form-select-sm" style="max-width:180px">
                        <option value="">Semua kategori</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" @selected(request('category')==$cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-outline-primary" style="border-color:#0F3D73;color:#0F3D73;">
                        Terapkan
                    </button>
                </form>
            </div>

            <div class="row g-3">
                @forelse($courses as $course)
                    <div class="col-md-6 col-lg-4">
                        <div class="card course-card h-100" data-aos="fade-up" data-aos-duration="550">
                            <div class="ratio ratio-16x9 course-thumb">
                               
                                <span class="course-thumb-badge">
                                    {{ $course->category->name ?? 'Umum' }}
                                </span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h3 class="course-title mb-1 text-truncate" title="{{ $course->title }}">
                                    {{ $course->title }}
                                </h3>
                                <p class="small text-muted mb-1">
                                    <i class="bi bi-person-workspace me-1"></i>
                                    {{ $course->teacher->name ?? 'Pengajar' }}
                                </p>
                                <p class="text-muted course-desc mb-3">
                                    {{ \Illuminate\Support\Str::limit($course->description, 80) }}
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center course-footer-text">
                                    <span class="text-muted">
                                        <i class="bi bi-people me-1"></i>
                                        {{ $course->students()->count() }} siswa
                                    </span>
                                    <a href="{{ route('courses.show',$course) }}"
                                       class="btn btn-sm text-white"
                                       style="background:#0F3D73;">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center">
                            Belum ada course yang tersedia.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-3">
                {{ $courses->withQueryString()->links() }}
            </div>
        </section>
    </div>
</x-app-layout>
