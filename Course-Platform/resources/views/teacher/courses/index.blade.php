<x-app-layout title="Kursus Saya – Teacher">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h5 mb-1">Kursus yang Saya Ajar</h1>
                <p class="small text-muted mb-0">
                    Kelola course, modul, dan materi pembelajaran yang kamu ajarkan.
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('teacher.private-chats.index') }}" class="btn btn-outline-primary btn-sm">
                    Lihat Chat
                </a>

                <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Course Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success small mb-3">
                {{ session('success') }}
            </div>
        @endif
        <div class="row g-3">
            @forelse($courses as $course)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2 small">
                                <span class="badge bg-light text-muted">
                                    {{ $course->category->name ?? 'Umum' }}
                                </span>

                                @if($course->is_active)
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="bi bi-check-circle me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        <i class="bi bi-x-circle me-1"></i> Nonaktif
                                    </span>
                                @endif
                            </div>
                            <h2 class="h6 fw-semibold mb-1 text-truncate" title="{{ $course->title }}">
                                {{ $course->title }}
                            </h2>
                            <p class="small text-muted mb-1">
                                <i class="bi bi-person-workspace me-1"></i>
                                {{ $course->teacher->name ?? 'Pengajar' }}
                            </p>
                            <p class="small text-muted mb-2">
                                <i class="bi bi-calendar-event me-1"></i>
                                @if($course->start_date || $course->end_date)
                                    @if($course->start_date)
                                        Mulai: {{ optional($course->start_date)->format('d M Y') }}
                                    @endif

                                    @if($course->end_date)
                                        &middot;
                                        Selesai: {{ optional($course->end_date)->format('d M Y') }}
                                    @endif
                                @else
                                    Dibuat: {{ optional($course->created_at)->format('d M Y') }}
                                @endif
                            </p>
                            <p class="small text-muted mb-3" style="min-height: 2.8em;">
                                {{ \Illuminate\Support\Str::limit($course->description, 80) }}
                            </p>
                            <div class="d-flex justify-content-between small text-muted mb-3">
                                <span>
                                    <i class="bi bi-people me-1"></i>
                                    {{ $course->students()->count() }} siswa
                                </span>
                                <span>
                                    <i class="bi bi-layers me-1"></i>
                                    {{ $course->modules->count() }} modul
                                </span>
                            </div>
                            <div class="mt-auto d-flex flex-column gap-2">
                                <a href="{{ route('teacher.courses.show', $course) }}"
                                   class="btn btn-sm btn-outline-primary w-100">
                                    Detail & Diskusi
                                </a>

                                <a href="{{ route('teacher.courses.modules.index', $course) }}"
                                   class="btn btn-sm btn-outline-primary w-100">
                                    <i class="bi bi-kanban me-1"></i> Kelola Modul
                                </a>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('teacher.courses.edit', $course) }}"
                                       class="btn btn-sm btn-warning flex-fill">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    <form action="{{ route('teacher.courses.destroy', $course) }}"
                                          method="POST"
                                          class="flex-fill"
                                          onsubmit="return confirm('Hapus course ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger w-100">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center rounded-4 py-4">
                        <i class="bi bi-emoji-neutral fs-3 d-block mb-2"></i>
                        <p class="mb-1">Anda belum membuat course.</p>
                        <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary btn-sm">
                            Buat Course Baru
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="mt-3">
            {{ $courses->links() }}
        </div>
    </div>
</x-app-layout>
