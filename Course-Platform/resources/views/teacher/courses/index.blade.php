<x-app-layout title="Kursus Saya – Teacher">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h5 mb-1">Kursus yang Saya Ajar</h1>
                <p class="small text-muted mb-0">
                    Kelola course, modul, dan materi pembelajaran.
                </p>
            </div>
            <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Buat Course Baru
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success small mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
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
                                    <a href="{{ route('teacher.courses.edit',$course) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="{{ route('teacher.courses.modules.index',$course) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-kanban me-1"></i> Modul
                                    </a>
                                    <form action="{{ route('teacher.courses.destroy',$course) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus course ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Anda belum membuat course.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
