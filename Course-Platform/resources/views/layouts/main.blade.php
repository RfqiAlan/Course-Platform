<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'LearnHub')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(180deg,#e7f2ff 0%,#f8fbff 40%,#ffffff 100%);
            min-height:100vh;
            font-family: system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
        }
        .navbar-brand{
            font-weight:700;
            letter-spacing:.5px;
        }
        .brand-pill{
            font-size:.7rem;
            padding:.15rem .5rem;
            border-radius:999px;
            background:#0d6efd1a;
            color:#0d6efd;
        }
        .nav-link{
            font-weight:500;
        }
        .nav-link.active{
            color:#0d6efd !important;
        }
        .hero{
            padding:3rem 1.25rem 2.5rem;
        }
        .hero-card{
            background:#ffffffcc;
            backdrop-filter: blur(12px);
            border-radius:18px;
            box-shadow:0 18px 40px rgba(15,23,42,.13);
            padding:2.25rem;
        }
        .hero-badge{
            font-size:.75rem;
            text-transform:uppercase;
            letter-spacing:.12em;
            color:#2563eb;
            background:#dbeafe;
            border-radius:999px;
            padding:.25rem .9rem;
            font-weight:600;
        }
        .hero-title{
            font-size:2rem;
            font-weight:700;
            color:#0f172a;
        }
        @media(min-width:992px){
            .hero-title{ font-size:2.5rem; }
        }
        .hero-subtitle{
            color:#4b5563;
            font-size:.95rem;
        }
        .btn-primary-soft{
            background:#e0edff;
            color:#1d4ed8;
            border-color:#bfdbfe;
        }
        .btn-primary-soft:hover{
            background:#d0e0ff;
            color:#1d4ed8;
        }
        .card-course{
            border:none;
            border-radius:16px;
            box-shadow:0 10px 30px rgba(15,23,42,.08);
            overflow:hidden;
            transition:.18s transform ease,.18s box-shadow ease;
        }
        .card-course:hover{
            transform:translateY(-3px);
            box-shadow:0 20px 45px rgba(15,23,42,.12);
        }
        .card-course-thumb{
            height:160px;
            background:linear-gradient(135deg,#60a5fa,#4f46e5);
            position:relative;
        }
        .card-course-thumb span{
            position:absolute;
            bottom:10px;
            left:12px;
            font-size:.75rem;
            padding:.15rem .6rem;
            border-radius:999px;
            background:#ffffffcc;
            color:#1d4ed8;
            backdrop-filter:blur(6px);
        }
        .card-course-body{
            padding:1rem 1rem 1.1rem;
        }
        .badge-level{
            font-size:.7rem;
            padding:.25rem .6rem;
            border-radius:999px;
        }
        .badge-level-beginner{
            background:#dcfce7;
            color:#15803d;
        }
        .badge-level-intermediate{
            background:#e0f2fe;
            color:#0369a1;
        }
        .badge-level-advanced{
            background:#fee2e2;
            color:#b91c1c;
        }
        .sidebar-sticky{
            position:sticky;
            top:5rem;
        }
        .lesson-item{
            border-radius:10px;
            padding:.45rem .6rem;
            font-size:.85rem;
            cursor:pointer;
        }
        .lesson-item.active{
            background:#e0edff;
            color:#1d4ed8;
            font-weight:600;
        }
        .lesson-item:hover{
            background:#eff6ff;
        }
        footer{
            font-size:.8rem;
            color:#6b7280;
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="bi bi-mortarboard-fill text-primary fs-4"></span>
            <span>LearnHub</span>
            <span class="brand-pill d-none d-md-inline">Final Web 2025</span>
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
                               href="{{ route('courses.index') }}?my=1">
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
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary px-3">
                            Masuk
                        </a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                        <a href="{{ route('register') }}" class="btn btn-sm btn-primary px-3">
                            Daftar
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- MAIN CONTENT --}}
<main class="py-3">
    @yield('content')
</main>

<footer class="border-top py-3">
    <div class="container d-flex flex-wrap justify-content-between gap-2">
        <span>&copy; {{ date('Y') }} LearnHub – Final Praktikum Pemrograman Web.</span>
        <span>Made with <span class="text-danger">&hearts;</span> & Bootstrap 5.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
