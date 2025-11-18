<div class="container py-4">
    {{-- HERO SECTION --}}
    <section class="mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <div class="p-4 p-lg-5 rounded-4 shadow-lg bg-white bg-opacity-90">
                    <div class="badge rounded-pill text-primary bg-primary-subtle mb-3">
                        Selamat Datang di LearnHub
                    </div>
                    <h1 class="fw-bold mb-3">
                        Platform Course Sederhana<br>
                        untuk Admin, Teacher, dan Student.
                    </h1>
                    <p class="text-muted mb-4">
                        Kelola course, modul, lesson, quiz, dan sertifikat dalam satu sistem.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-search me-2"></i> Jelajahi Course
                        </a>
                        @auth
                            @if(auth()->user()->role === 'student')
                                <a href="{{ route('student.courses.index') }}" class="btn btn-outline-primary btn-lg px-4">
                                    Kursus Saya
                                </a>
                            @elseif(auth()->user()->role === 'teacher')
                                <a href="{{ route('teacher.courses.index') }}" class="btn btn-outline-primary btn-lg px-4">
                                    Dashboard Teacher
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-primary btn-lg px-4">
                                    Panel Admin
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">
                                Login untuk mulai belajar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="col-lg-5 d-none d-lg-block">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body">
                        <p class="small text-muted mb-2">Fitur Singkat</p>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-1">
                                <i class="bi bi-check2-circle text-success me-2"></i>
                                Struktur: Course → Modul → Lesson → Konten.
                            </li>
                            <li class="mb-1">
                                <i class="bi bi-check2-circle text-success me-2"></i>
                                Quiz dengan soal dan opsi pilihan ganda.
                            </li>
                            <li class="mb-1">
                                <i class="bi bi-check2-circle text-success me-2"></i>
                                Role-based: Admin, Teacher, Student.
                            </li>
                            <li class="mb-1">
                                <i class="bi bi-check2-circle text-success me-2"></i>
                                Sertifikat digital setelah course selesai.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
