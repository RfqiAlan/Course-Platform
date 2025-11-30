{{-- resources/views/courses/catalog.blade.php --}}

@push('styles')
    <style>
        /* HERO CARD SATU SAJA */
        .catalog-hero-card {
            background: radial-gradient(circle at top left, #EAF2FF 0, #ffffff 55%, #FDF7FF 100%);
            border-radius: 24px;
            border: 1px solid rgba(15, 61, 115, 0.08);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
        }

        .catalog-hero-tag {
            font-size: .8rem;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .catalog-hero-title {
            font-size: 2rem;
        }

        @media (min-width: 992px) {
            .catalog-hero-title {
                font-size: 2.3rem;
            }
        }

        .catalog-hero-subtitle {
            font-size: .95rem;
            max-width: 36rem;
        }

        .catalog-stat-number {
            font-weight: 700;
            font-size: 1.4rem;
        }

        .catalog-stat-label {
            font-size: .8rem;
        }

        .catalog-pill-info {
            border-radius: 999px;
            background: rgba(15, 61, 115, 0.06);
            font-size: .78rem;
            padding: .3rem .7rem;
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
            <div class="catalog-hero-card p-4 p-lg-5 text-center" data-aos="fade-up" data-aos-duration="600">

                <div class="d-flex justify-content-center mb-3">
                    <div class="badge rounded-pill px-3 py-2 catalog-hero-tag"
                        style="background:#EAF2FF;color:#0F3D73;">
                        Katalog Kursus EDVO
                    </div>
                </div>

                <h1 class="fw-bold mb-3 catalog-hero-title">
                    Temukan Kursus Terbaik<br>
                    untuk Perjalanan Belajarmu.
                </h1>

                <p class="text-muted mb-4 catalog-hero-subtitle mx-auto">
                    Jelajahi ratusan kursus dari berbagai kategori. Gunakan filter untuk mencari
                    berdasarkan kategori, pengajar, dan minat belajarmu — dari level dasar hingga lanjutan.
                </p>

                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                    <a href="#course-list" class="btn btn-primary btn-lg px-4"
                        style="background:#0F3D73;border-color:#0F3D73;">
                        <i class="bi bi-search me-2"></i> Cari Kursus
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-4"
                            style="border-color:#0F3D73;color:#0F3D73;">
                            Masuk untuk mulai belajar
                        </a>
                    @endguest
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-3 text-muted small mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span>Struktur Course → Modul → Lesson</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span>Progress terekam & sertifikat digital</span>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-4">
                    <div>
                        <div class="catalog-stat-number" style="color:#FFC400;">
                            {{ $courses->total() }}+
                        </div>
                        <div class="catalog-stat-label text-muted">Kursus aktif</div>
                    </div>

                    @if(isset($categories) && count($categories))
                        <div>
                            <div class="catalog-stat-number" style="color:#3396FF;">
                                {{ count($categories) }}+
                            </div>
                            <div class="catalog-stat-label text-muted">Kategori belajar</div>
                        </div>
                    @endif
                </div>
            </div>
        </section>


        <section id="course-list" class="pb-4" data-aos="fade-up" data-aos-duration="600">

            <div
                class="mb-3 p-3 p-md-3 rounded-4 bg-white shadow-sm d-flex flex-wrap justify-content-between align-items-center gap-3">
                <h2 class="h6 mb-0">Daftar Kursus</h2>

                <form method="GET" action="{{ route('courses.index') }}"
                    class="d-flex flex-wrap gap-2 align-items-center">

                    <div class="input-group input-group-sm" style="max-width:260px">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" name="search" value="{{ $search ?? '' }}"
                            placeholder="Cari judul / pengajar">
                    </div>

                    <select name="category_id" class="form-select form-select-sm" style="max-width:180px">
                        <option value="">Semua kategori</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" {{ (string) ($categoryId ?? '') === (string) $cat->id ? 'selected' : '' }}>
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
                            <div class="card-body d-flex flex-column">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-light text-muted border">
                                        {{ $course->category->name ?? 'Umum' }}
                                    </span>

                                    @if(property_exists($course, 'is_active') || isset($course->is_active))
                                        @if($course->is_active)
                                            <span class="badge bg-success-subtle text-success small">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary small">
                                                Nonaktif
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                <h3 class="course-title mb-1 text-truncate" title="{{ $course->title }}">
                                    {{ $course->title }}
                                </h3>
                                <p class="small text-muted mb-2">
                                    <i class="bi bi-person-workspace me-1"></i>
                                    {{ $course->teacher->name ?? 'Pengajar' }}
                                </p>

                                <p class="text-muted course-desc mb-3">
                                    {{ \Illuminate\Support\Str::limit($course->description, 80) }}
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center course-footer-text">
                                    <span class="text-muted">
                                        <i class="bi bi-people me-1"></i>
                                        {{ $course->students_count ?? $course->students()->count() }} siswa
                                    </span>
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-sm text-white"
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
                            Belum ada course yang tersedia atau tidak cocok dengan filter.
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