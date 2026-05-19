<x-app-layout :title="'Lesson: '.$module->title">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h5 mb-1">Lesson dalam Modul</h1>
                <p class="small text-muted mb-0">
                    Modul: <strong>{{ $module->title }}</strong><br>
                    Course: <strong>{{ $course->title }}</strong>
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('teacher.courses.modules.index', ['course' => $course->id]) }}"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('teacher.courses.modules.lessons.create', [
                            'course' => $course->id,
                            'module' => $module->id,
                        ]) }}"
                   class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Lesson
                </a>
            </div>
        </div>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th style="width: 90px;">Urutan</th>
                            <th>Judul Lesson</th>
                            <th>Ringkasan</th>
                            <th class="text-end" style="width: 240px;">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($lessons as $lesson)
                            <tr>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">
                                        {{ $lesson->order }}
                                    </span>
                                </td>
                                <td class="fw-semibold">
                                    {{ $lesson->title }}
                                </td>
                                <td class="text-muted">
                                    {{ \Illuminate\Support\Str::limit($lesson->summary ?? $lesson->description, 80) }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('teacher.lessons.edit', $lesson) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="{{ route('teacher.courses.modules.lessons.contents.index', [
                                                'course' => $course->id,
                                                'module' => $module->id,
                                                'lesson' => $lesson->id,
                                            ]) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-text me-1"></i> Konten
                                    </a>
                                    <form action="{{ route('teacher.lessons.destroy', $lesson) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus lesson ini beserta kontennya?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <div class="mb-2">
                                        <i class="bi bi-collection fs-3 d-block mb-1"></i>
                                        Belum ada lesson untuk modul ini.
                                    </div>
                                    <a href="{{ route('teacher.courses.modules.lessons.create', [
                                                'course' => $course->id,
                                                'module' => $module->id,
                                            ]) }}"
                                       class="btn btn-primary btn-sm">
                                        Tambah Lesson Pertama
                                    </a>
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
