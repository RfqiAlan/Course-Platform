<x-app-layout title="Kursus Saya – LearnHub">
    <div class="container py-4">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">Kursus yang Saya Ikuti</h1>
                <p class="small text-muted mb-0">
                    Lihat semua course yang sudah kamu enroll, lengkap dengan progress belajar.
                </p>
            </div>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-search me-1"></i> Cari Course Lain
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
                            <th>Course</th>
                            <th>Kategori</th>
                            <th>Pengajar</th>
                            <th style="width:200px;">Progress</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($courses as $item)
                            @php
                                $course   = $item->course ?? $item; // tergantung relasi
                                $progress = $item->progress_percent ?? ($item->pivot->progress ?? 0);
                                $isDone   = $item->is_completed ?? ($item->pivot->is_completed ?? false);
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-semibold text-truncate" style="max-width:220px;">
                                        {{ $course->title }}
                                    </div>
                                </td>
                                <td>{{ $course->category->name ?? '-' }}</td>
                                <td>{{ $course->teacher->name ?? '-' }}</td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">{{ $progress }}%</span>
                                        </div>
                                        <div class="progress" style="height:6px;">
                                            <div class="progress-bar bg-primary"
                                                 style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($isDone)
                                        <span class="badge bg-success-subtle text-success">
                                            Selesai
                                        </span>
                                    @elseif($progress > 0)
                                        <span class="badge bg-primary-subtle text-primary">
                                            Sedang dipelajari
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Belum mulai
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('student.courses.learn',$course) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-play-circle me-1"></i> Belajar
                                    </a>
                                    @if($isDone)
                                        <a href="{{ route('student.certificates.index') }}"
                                           class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-award me-1"></i> Sertifikat
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Kamu belum mengikuti course apa pun.
                                    <br>
                                    <a href="{{ route('courses.index') }}">Mulai cari course di sini.</a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($courses instanceof \Illuminate\Pagination\AbstractPaginator)
                    <div class="mt-3">
                        {{ $courses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
