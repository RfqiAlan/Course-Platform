<x-app-layout :title="'Modul: '.$course->title">
    <div class="container py-4">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">Modul Kursus</h1>
                <p class="small text-muted mb-0">
                    Atur urutan modul & lesson untuk course: <strong>{{ $course->title }}</strong>
                </p>
            </div>
            <a href="{{ route('teacher.courses.modules.create', ['course' => $course->id]) }}"
               class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Modul
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th>Urutan</th>
                            <th>Judul Modul</th>
                            <th>Jumlah Lesson</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($modules as $module)
                            <tr>
                                <td>{{ $module->order }}</td>
                                <td>{{ $module->title }}</td>
                                <td>{{ $module->lessons->count() }}</td>
                                <td class="text-end">
                                    {{-- EDIT (shallow) --}}
                                    <a href="{{ route('teacher.modules.edit', $module) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- LIHAT LESSON: pakai route nested --}}
                                    <a href="{{ route('teacher.courses.modules.lessons.index', [
                                                'course' => $course->id,
                                                'module' => $module->id,
                                            ]) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-list-task me-1"></i> Lesson
                                    </a>

                                    {{-- HAPUS (shallow) --}}
                                    <form action="{{ route('teacher.modules.destroy', $module) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus modul ini beserta lesson-nya?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Belum ada modul untuk course ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
