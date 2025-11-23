<x-app-layout :title="$course->title.' – EDVO'">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body">
                        <span class="badge bg-primary-subtle text-primary small mb-2">
                            {{ $course->category->name ?? 'Tanpa Kategori' }}
                        </span>
                        <h1 class="h4 mb-1">{{ $course->title }}</h1>
                        <p class="small text-muted mb-2">
                            <i class="bi bi-person-workspace me-1"></i>
                            Pengajar: {{ $course->teacher->name ?? 'Pengajar' }}
                        </p>
                        <p class="text-muted mb-0" style="white-space:pre-line">
                            {{ $course->description }}
                        </p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Kurikulum Kursus</h2>
                        @forelse($course->modules as $module)
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <div class="badge rounded-pill text-bg-primary me-2">
                                        Modul {{ $loop->iteration }}
                                    </div>
                                    <span class="fw-semibold">{{ $module->title }}</span>
                                </div>
                                <ul class="list-unstyled ms-4 small text-muted mb-1">
                                    @foreach($module->lessons as $lesson)
                                        <li class="d-flex align-items-center mb-1">
                                            <i class="bi bi-play-circle me-2 text-primary"></i>
                                            <span>{{ $lesson->title }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @empty
                            <p class="small text-muted mb-0">Belum ada modul tersusun.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body">
                        <div class="ratio ratio-16x9 rounded-3 mb-3"
                             style="background:linear-gradient(135deg,#93c5fd,#1d4ed8);">
                            <div class="d-flex justify-content-center align-items-center text-white">
                                <i class="bi bi-play-circle-fill fs-1"></i>
                            </div>
                        </div>

                        <p class="small mb-1 text-muted">
                            <i class="bi bi-people me-1 text-primary"></i>
                            {{ $course->students()->count() }} siswa terdaftar
                        </p>

                        @guest
                            <a href="{{ route('register') }}" class="btn btn-primary w-100 mb-2">
                                Login untuk Mengikuti Course
                            </a>
                            <p class="small text-muted mb-0 text-center">
                                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>.
                            </p>
                        @else
                            @if(auth()->user()->isStudent())
                                @if(auth()->user()->enrolledCourses->contains($course->id))
                                    <a href="{{ route('student.courses.learn',$course) }}"
                                       class="btn btn-success w-100 mb-2">
                                        <i class="bi bi-play-circle me-1"></i>
                                        Lanjutkan Belajar
                                    </a>
                                @else
                                    <form action="{{ route('student.courses.enroll',$course) }}" method="POST" class="mb-2">
                                        @csrf
                                        <button class="btn btn-primary w-100">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Ikuti Course
                                        </button>
                                    </form>
                                @endif
                            @else
                                <div class="alert alert-warning small mb-0">
                                    Anda login sebagai <strong>{{ auth()->user()->role }}</strong>.
                                    Hanya akun <strong>student</strong> yang dapat mengikuti kursus.
                                </div>
                            @endif
                        @endguest
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body small text-muted">
                        <h2 class="h6 mb-3">Info kursus</h2>
                        <p class="mb-1">
                            <i class="bi bi-clock-history me-2"></i>
                            {{ $course->modules->sum(fn($m)=>$m->lessons->count()) }} lesson
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-patch-question me-2"></i>
                            Kuis interaktif & sertifikat
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-chat-dots me-2"></i>
                            Forum diskusi & live chat
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
