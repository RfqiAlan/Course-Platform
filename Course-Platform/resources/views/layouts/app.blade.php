<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? config('app.name','LearnHub') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background:linear-gradient(180deg,#e7f2ff 0%,#f8fbff 40%,#ffffff 100%);
            min-height:100vh;
            font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
        }
        .navbar-brand{font-weight:700;letter-spacing:.5px}
        .brand-pill{
            font-size:.7rem;padding:.15rem .5rem;border-radius:999px;
            background:#0d6efd1a;color:#0d6efd;
        }
        .nav-link{font-weight:500}
        .nav-link.active{color:#0d6efd!important}
        main{padding-top:1.25rem;padding-bottom:1.25rem}
        footer{font-size:.8rem;color:#6b7280}
    </style>

    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="bi bi-mortarboard-fill text-primary fs-4"></span>
            <span>LearnHub</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}"
                       href="{{ route('courses.index') }}">Kursus</a>
                </li>

                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ str_starts_with(request()->path(),'admin') ? 'active' : '' }}"
                               href="#" data-bs-toggle="dropdown">
                                Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Manajemen User</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Kategori</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.courses.index') }}">Course</a></li>
                            </ul>
                        </li>
                    @endif

                    @if(auth()->user()->isTeacher())
                        <li class="nav-item">
                            <a class="nav-link {{ str_starts_with(request()->path(),'teacher') ? 'active' : '' }}"
                               href="{{ route('teacher.courses.index') }}">
                                Kursus Saya
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->isStudent())
                        <li class="nav-item">
                            <a class="nav-link {{ str_starts_with(request()->path(),'student') ? 'active' : '' }}"
                               href="{{ route('student.courses.index') }}?my=1">
                                Kursus Diikuti
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-1"
                           href="#" data-bs-toggle="dropdown">
                            <span class="bi bi-person-circle"></span>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-gear me-2"></i>Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary px-3">Masuk</a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                        <a href="{{ route('register') }}" class="btn btn-sm btn-primary px-3">Daftar</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main>
    {{ $slot }}
</main>

<footer class="border-top py-3">
    <div class="container d-flex flex-wrap justify-content-between gap-2">
        <span>&copy; {{ date('Y') }} LearnHub – Final Praktikum Web.</span>
        <span>Made with <span class="text-danger">&hearts;</span> & Bootstrap 5.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: @json(session('error')),
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`
            });
        @endif
    });
</script>

@stack('scripts')
</body>
</html>
