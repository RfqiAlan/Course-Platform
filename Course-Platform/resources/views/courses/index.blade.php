<x-app-layout title="Katalog Kursus – LearnHub">
    <div class="container">
        {{-- HERO --}}
        <section class="py-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <div class="p-4 p-lg-5 rounded-4 shadow-lg bg-white bg-opacity-90">
                        <div class="badge rounded-pill text-primary bg-primary-subtle mb-3">
                            Katalog Kursus
                        </div>
                        <h1 class="fw-bold mb-3">Temukan kursus yang sesuai dengan kebutuhanmu.</h1>
                        <p class="text-muted mb-4">
                            Filter berdasarkan kategori, pengajar, dan ikuti course yang sesuai
                            dengan minatmu.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#course-list" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-search me-2"></i> Cari Kursus
                            </a>
                            @auth
                                @if(auth()->user()->isStudent())
                                    <a href="{{ route('courses.index') }}?my=1"
                                       class="btn btn-outline-primary btn-lg px-4">
                                        Kursus Saya
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
                 @if($course->preview_video)
    <div class="ratio ratio-16x9 rounded-3 mb-3">
        <video controls class="rounded-3 w-100">
            <source src="{{ Storage::url($course->preview_video) }}" type="video/mp4">
        </video>
    </div>
@endif

            </div>
        </section>

        {{-- FILTER + LIST --}}
        <section id="course-list" class="pb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <h2 class="h5 mb-0">Daftar Kursus</h2>
                <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    <div class="input-group input-group-sm" style="max-width:260px">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0"
                               name="q" value="{{ request('q') }}" placeholder="Cari judul/pengajar">
                    </div>
                    <select name="category" class="form-select form-select-sm" style="max-width:180px">
                        <option value="">Semua kategori</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" @selected(request('category')==$cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-outline-primary">
                        Terapkan
                    </button>
                </form>
            </div>

            <div class="row g-3">
                @forelse($courses as $course)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4">
                            <div class="ratio ratio-16x9 rounded-top-4"
                                 style="background:linear-gradient(135deg,#60a5fa,#4f46e5);">
                                <div class="p-2">
                                    <span class="badge bg-white text-primary small">
                                        {{ $course->category->name ?? 'Umum' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="h6 text-truncate" title="{{ $course->title }}">
                                    {{ $course->title }}
                                </h3>
                                <p class="small text-muted mb-1">
                                    <i class="bi bi-person-workspace me-1"></i>
                                    {{ $course->teacher->name ?? 'Pengajar' }}
                                </p>
                                <p class="small text-muted mb-3" style="min-height:2.7em">
                                    {{ \Illuminate\Support\Str::limit($course->description, 70) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="text-muted">
                                        <i class="bi bi-people me-1"></i>{{ $course->students()->count() }} siswa
                                    </span>
                                    <a href="{{ route('courses.show',$course) }}"
                                       class="btn btn-sm btn-primary">
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
