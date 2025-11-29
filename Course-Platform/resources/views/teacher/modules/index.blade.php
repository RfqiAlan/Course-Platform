<x-app-layout :title="'Modul: '.$course->title">
    <div class="container py-4">
    @php
    $backUrl = auth()->user()->role === 'admin'
        ? route('admin.courses.index')
        : route('teacher.courses.index');
@endphp
        {{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h5 mb-1">Modul Kursus</h1>
        <p class="small text-muted mb-0">
            Atur urutan modul & lesson untuk course: <strong>{{ $course->title }}</strong>
        </p>
    </div>

    <div class="d-flex gap-2">
        {{-- BACK BUTTON DINAMIS --}}
        <a href="{{ $backUrl }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>

        <a href="{{ route('teacher.courses.modules.create', ['course' => $course->id]) }}"
           class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Modul
        </a>
    </div>
</div>

        {{-- CARD --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th style="width: 90px;">Urutan</th>
                            <th>Judul Modul</th>
                            <th style="width: 170px;">Jumlah Lesson</th>
                            <th class="text-end" style="width: 220px;">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($modules as $module)
                            <tr>
                                {{-- URUTAN --}}
                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">
                                        {{ $module->order }}
                                    </span>
                                </td>

                                {{-- JUDUL --}}
                                <td class="fw-semibold">
                                    {{ $module->title }}
                                </td>

                                {{-- JUMLAH LESSON (STYLE BARU) --}}
                                <td>
                                    <span class="badge bg-light text-muted border d-inline-flex align-items-center gap-1 px-3 py-1 rounded-pill">
                                        <i class="bi bi-journal-text"></i>
                                        {{ $module->lessons->count() }} lesson
                                    </span>
                                </td>

                                {{-- AKSI (TIDAK DIUBAH) --}}
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
                                <td colspan="4" class="text-center text-muted py-4">
                                    <div class="mb-2">
                                        <i class="bi bi-folder-x fs-3 d-block mb-1"></i>
                                        Belum ada modul untuk course ini.
                                    </div>
                                    <a href="{{ route('teacher.courses.modules.create', ['course' => $course->id]) }}"
                                       class="btn btn-primary btn-sm">
                                        Tambah Modul Pertama
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
