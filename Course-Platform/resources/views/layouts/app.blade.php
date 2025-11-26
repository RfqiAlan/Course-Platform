<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? config('app.name','EDVO') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- AOS (Animate On Scroll) --}}
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            /* Override warna primary Bootstrap dengan warna brand kamu */
            --bs-primary: #0F3D73;
            --bs-primary-rgb: 15, 61, 115;
        }

        body{
            background:linear-gradient(180deg,#e7f2ff 0%,#f8fbff 40%,#ffffff 100%);
            min-height:100vh;
            font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
        }

        .navbar-brand{
            font-weight:700;
            letter-spacing:.5px;
        }

        .brand-pill{
            font-size:.7rem;
            padding:.15rem .5rem;
            border-radius:999px;
            background:#0F3D731a;
            color:#0F3D73;
        }

        .nav-link{
            font-weight:500;
        }

        .nav-link.active{
            color:#0F3D73!important;
        }

        main{
            padding-top:1.25rem;
            padding-bottom:1.25rem;
        }

        footer{
            font-size:.8rem;
            color:#6b7280;
        }

        /* AOS helper untuk hide sebelum animasi */
        [data-aos][data-aos][data-aos-duration="0"] {
            transition-duration: 0s;
        }
    </style>

    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top" data-aos="fade-down" data-aos-duration="500">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('logo/logo.jpeg') }}" alt="Logo" style="height: 48px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                {{-- BERANDA --}}
                <li class="nav-item">
                    <a class="nav-link
                        {{ request()->routeIs([
                            'home',                // guest homepage
                            'dashboard',           // kalau masih dipakai
                            'student.dashboard',   // dashboard student
                            'teacher.courses.index', // dashboard teacher
                            'admin.courses.index'    // dashboard admin
                        ]) ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        Beranda
                    </a>
                </li>

                {{-- KURSUS (PUBLIC) --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}"
                       href="{{ route('courses.index') }}">
                        Kursus
                    </a>
                </li>

                @auth
                    {{-- ADMIN --}}
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

                    {{-- TEACHER --}}
                    @if(auth()->user()->isTeacher())
                        <li class="nav-item">
                            <a class="nav-link {{ str_starts_with(request()->path(),'teacher') ? 'active' : '' }}"
                               href="{{ route('teacher.courses.index') }}">
                                Kursus Saya
                            </a>
                        </li>
                    @endif

                    {{-- STUDENT: KURSUS DIIKUTI --}}
                    @if(auth()->user()->isStudent())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('student.courses.*') ? 'active' : '' }}"
                               href="{{ route('student.courses.index') }}?my=1">
                                Kursus Diikuti
                            </a>
                        </li>
                    @endif

                    {{-- USER DROPDOWN --}}
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


<main data-aos="fade-up" data-aos-duration="600" data-aos-easing="ease-out-cubic">
    {{ $slot }}
</main>

<footer class="border-top py-3" data-aos="fade-up" data-aos-duration="500">
    <div class="container d-flex flex-wrap justify-content-between gap-2">
        <span>&copy; {{ date('Y') }} EDVO – EDUCATION VIRTUAL ONLINE.</span>        
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- AOS JS --}}
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init AOS
        AOS.init({
            once: true,              // animasi hanya sekali
            duration: 600,           // default durasi
            easing: 'ease-out-cubic' // easing enak dilihat
        });

        // Konfigurasi toast (snackbar) di kanan atas
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end', // kanan atas
            showConfirmButton: false,
            timer: 2600,
            timerProgressBar: true,
            customClass: {
                popup: 'shadow-sm'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: @json(session('success'))
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: @json(session('error'))
            });
        @endif

        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: 'Validasi gagal',
                text: '{{ $errors->first() }}'
            });
        @endif
    });
</script>

@stack('scripts')
</body>
</html>
