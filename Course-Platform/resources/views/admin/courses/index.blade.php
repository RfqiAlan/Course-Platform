<x-app-layout title="Manajemen Course – Admin">
    <div class="py-4">
        <div class="container">

            {{-- PAGE HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h4 mb-1">Manajemen Course</h1>
                    <p class="text-muted small mb-0">
                        Kelola semua course, assign ke teacher, dan atur status aktif dengan mudah.
                    </p>
                </div>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Course
                </a>
            </div>

            {{-- CARD WRAPPER --}}
            <div class="card border-0 shadow-sm rounded-4">
                {{-- CARD HEADER: FILTERS --}}
                <div class="card-header bg-white border-0 pb-0">
                    @if(session('success'))
                        <div class="alert alert-success border-0 small d-flex align-items-center mb-3">
                            <i class="bi bi-check-circle me-2"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="small text-muted">
                            Menampilkan
                            <strong>{{ $courses->total() }}</strong> course
                            @if(request('search') || request('category') || request('status'))
                                dengan filter aktif.
                            @else
                                tanpa filter.
                            @endif
                        </div>
                        @if(request('search') || request('category') || request('status'))
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-link btn-sm text-decoration-none small">
                                Reset filter
                            </a>
                        @endif
                    </div>

                    <form method="GET" class="row g-2 align-items-center small mb-3">
                        {{-- SEARCH --}}
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control border-start-0"
                                    placeholder="Cari judul course">
                            </div>
                        </div>

                        {{-- CATEGORY FILTER --}}
                        <div class="col-md-3">
                            <select name="category" class="form-select form-select-sm">
                                <option value="">Semua kategori</option>
                                @foreach($categories ?? [] as $cat)
                                    <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- STATUS FILTER --}}
                        <div class="col-md-3">
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Semua status</option>
                                <option value="active"   @selected(request('status') === 'active')>Aktif</option>
                                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                            </select>
                        </div>

                        {{-- APPLY BUTTON --}}
                        <div class="col-md-2 text-md-end">
                            <button class="btn btn-outline-primary btn-sm w-100">
                                Terapkan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- CARD BODY: TABLE --}}
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Judul</th>
                                    <th>Teacher</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 80px;">Siswa</th>
                                    <th class="text-end" style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse($courses as $course)
                                    <tr>
                                        {{-- NOMOR --}}
                                        <td>{{ $loop->iteration + ($courses->firstItem() - 1) }}</td>

                                        {{-- JUDUL + LINK PUBLIC --}}
                                        <td>
                                            <div class="fw-semibold mb-0">
                                                <a href="{{ route('courses.show', $course) }}"
                                                   target="_blank"
                                                   class="text-decoration-none">
                                                    {{ $course->title }}
                                                </a>
                                            </div>
                                            <div class="text-muted small">
                                                {{ Str::limit($course->short_description ?? '', 90) }}
                                            </div>
                                        </td>

                                        {{-- TEACHER --}}
                                        <td>
                                            @if($course->teacher)
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                                         style="width: 28px; height: 28px; font-size: 0.75rem;">
                                                        {{ strtoupper(substr($course->teacher->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold small mb-0">
                                                            {{ $course->teacher->name }}
                                                        </div>
                                                        <div class="text-muted xsmall">
                                                            Teacher
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Belum di-assign</span>
                                            @endif
                                        </td>

                                        {{-- KATEGORI --}}
                                        <td>
                                            @if($course->category)
                                                <span class="badge rounded-pill text-bg-light">
                                                    {{ $course->category->name }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        {{-- STATUS --}}
                                        <td>
                                            @if($course->is_active)
                                                <span class="badge bg-success-subtle text-success rounded-pill">
                                                    <i class="bi bi-check-circle me-1"></i>Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill">
                                                    <i class="bi bi-pause-circle me-1"></i>Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        {{-- TOTAL SISWA --}}
                                        <td class="text-center">
                                            {{ $course->students()->count() }}
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="text-end">
                                            {{-- KELola MODUL & MATERI (AREA TEACHER) --}}
                                            <a href="{{ route('teacher.courses.modules.index', ['course' => $course->id]) }}"
                                               class="btn btn-outline-primary btn-sm me-1"
                                               title="Kelola modul & materi">
                                                <i class="bi bi-kanban"></i>
                                            </a>

                                            {{-- EDIT COURSE (META) --}}
                                            <a href="{{ route('admin.courses.edit', $course) }}
                                               "class="btn btn-outline-secondary btn-sm me-1"
                                               title="Edit course">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- HAPUS COURSE --}}
                                            <form action="{{ route('admin.courses.destroy', $course) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Hapus course &quot;{{ $course->title }}&quot;? Modul/lesson yang terkait akan ikut terhapus. Lanjutkan?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-sm"
                                                        title="Hapus course">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">
                                            <div class="mb-2">
                                                <i class="bi bi-journal-x" style="font-size: 2.5rem;"></i>
                                            </div>
                                            <div class="fw-semibold mb-1">
                                                Belum ada course yang terdaftar
                                            </div>
                                            <p class="small mb-3">
                                                Mulai buat course pertama dan assign ke teacher untuk membuka pendaftaran siswa.
                                            </p>
                                            <a href="{{ route('admin.courses.create') }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="bi bi-plus-circle me-1"></i> Tambah Course
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    @if($courses->hasPages())
                        <div class="mt-3">
                            {{ $courses->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
