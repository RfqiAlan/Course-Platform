<x-app-layout title="Manajemen Course – Admin">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h5 mb-1">Manajemen Course</h1>
                <p class="small text-muted mb-0">
                    Kelola semua course, assign ke teacher, dan atur status aktif.
                </p>
            </div>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Course
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success small mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="GET" class="row g-2 align-items-center small mb-3">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control border-start-0"
                                   placeholder="Cari judul course">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select form-select-sm">
                            <option value="">Semua kategori</option>
                            @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat->id }}" @selected(request('category')==$cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua status</option>
                            <option value="active"   @selected(request('status')==='active')>Aktif</option>
                            <option value="inactive" @selected(request('status')==='inactive')>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-md-end">
                        <button class="btn btn-outline-primary btn-sm w-100">
                            Terapkan
                        </button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Teacher</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th class="text-center">Siswa</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($courses as $course)
                            <tr>
                                <td>{{ $loop->iteration + ($courses->firstItem() - 1) }}</td>
                                <td>
                                    <a href="{{ route('courses.show',$course) }}" target="_blank">
                                        {{ $course->title }}
                                    </a>
                                </td>
                                <td>{{ $course->teacher->name ?? '-' }}</td>
                                <td>{{ $course->category->name ?? '-' }}</td>
                                <td>
                                    @if($course->is_active)
                                        <span class="badge text-bg-success-subtle text-success">Aktif</span>
                                    @else
                                        <span class="badge text-bg-secondary-subtle text-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $course->students()->count() }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.courses.edit',$course) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.courses.destroy',$course) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus course ini? Modul/lesson yang terkait akan ikut terhapus. Lanjutkan?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    Belum ada course.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $courses->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
