<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'EDVO') }}</title>

    {{-- 1. Google Fonts: Plus Jakarta Sans (Tampilan Lebih Modern) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- 2. Bootstrap 5 & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- 3. AOS Animation --}}
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #0F3D73;
            --bs-primary-rgb: 15, 61, 115;
            --bs-body-bg: #f8fafc; /* Warna background sedikit abu-abu sangat muda */
            --bs-body-font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bs-body-bg);
            /* Background pattern halus (opsional) */
            background-image: radial-gradient(#e7f2ff 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* --- Navbar Glass Effect --- */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .navbar-brand img {
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        /* --- Nav Links --- */
        .nav-link {
            font-weight: 500;
            color: #64748b; /* Slate-500 equivalent */
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--bs-primary) !important;
        }

        /* Indikator Aktif Pill Kecil */
        .nav-link.active {
            font-weight: 600;
            background-color: rgba(15, 61, 115, 0.08);
            border-radius: 8px;
        }

        /* --- Buttons --- */
        .btn-primary {
            box-shadow: 0 4px 6px -1px rgba(15, 61, 115, 0.2), 0 2px 4px -1px rgba(15, 61, 115, 0.1);
            transition: transform 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(15, 61, 115, 0.2);
        }

        /* --- Dropdown Animation --- */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            margin-top: 10px !important;
            animation: fadeInDropdown 0.2s ease-out forwards;
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.9rem;
            color: #475569;
        }
        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: var(--bs-primary);
        }
        .dropdown-item.text-danger:hover {
            background-color: #fef2f2;
            color: #dc2626 !important;
        }

        @keyframes fadeInDropdown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- Avatar --- */
        .avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0F3D73, #3b82f6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            border: 2px solid white;
            box-shadow: 0 0 0 2px rgba(15, 61, 115, 0.1);
        }

        /* --- Footer --- */
        footer {
            background-color: #fff;
            border-top: 1px solid #e2e8f0;
        }
    </style>

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

@php
    $user = auth()->user();
@endphp

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-glass sticky-top py-3" data-aos="fade-down" data-aos-duration="600">
    <div class="container">
        
        {{-- LOGO --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            {{-- Pastikan path logo benar --}}
            <img src="{{ asset('logo/logo.jpeg') }}" alt="EDVO" style="height: 40px; width: auto; border-radius: 10px;">
            <span class="d-none d-sm-block fw-bold text-primary" style="letter-spacing: -0.5px;">EDVO</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1 gap-lg-2 mt-3 mt-lg-0">

                {{-- Link: Beranda --}}
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs(['home', 'dashboard', '*.dashboard']) ? 'active' : '' }}" 
                       href="{{ $user ? route('dashboard') : route('home') }}">
                        Beranda
                    </a>
                </li>

                {{-- Link: Kursus Public --}}
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('courses.*') ? 'active' : '' }}" 
                       href="{{ route('courses.index') }}">
                        Katalog Kursus
                    </a>
                </li>

                @auth
                    {{-- DROPDOWN MENU BERDASARKAN ROLE --}}
                    
                    {{-- 1. ADMIN MENU --}}
                    @if($user->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle px-3 {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                                Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header text-uppercase small fw-bold">Menu Admin</h6></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-grid me-2 text-primary"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        <i class="bi bi-people me-2 text-primary"></i>Manajemen User
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.categories.index') }}">
                                        <i class="bi bi-tags me-2 text-primary"></i>Kategori
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.courses.index') }}">
                                        <i class="bi bi-journal-text me-2 text-primary"></i>Semua Kursus
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- 2. TEACHER MENU --}}
                    @if($user->isTeacher())
                        <li class="nav-item">
                            <a class="nav-link px-3 {{ request()->routeIs('teacher.courses.*') ? 'active' : '' }}" 
                               href="{{ route('teacher.courses.index') }}">
                                Kursus Saya
                            </a>
                        </li>
                    @endif

                    {{-- 3. STUDENT MENU --}}
                    @if($user->isStudent())
                        <li class="nav-item">
                            <a class="nav-link px-3 {{ request()->routeIs('student.courses.*') ? 'active' : '' }}" 
                               href="{{ route('student.courses.index') }}?my=1">
                                Belajarku
                            </a>
                        </li>
                    @endif

                    {{-- USER PROFILE DROPDOWN --}}
                    <li class="nav-item dropdown ms-lg-2 ps-lg-3 border-start-lg">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-0" href="#" data-bs-toggle="dropdown">
                            <div class="text-end d-none d-lg-block lh-1">
                                <div class="fw-bold text-dark small">{{ Str::limit($user->name, 15) }}</div>
                                <div class="text-xs text-muted">{{ ucfirst($user->role) }}</div>
                            </div>
                            <div class="avatar-circle">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            {{-- Info Mobile Only --}}
                            <li class="d-lg-none px-3 py-2 bg-light rounded-top mb-1">
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <div class="small text-muted">{{ $user->email }}</div>
                            </li>
                            
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-gear me-2"></i>Pengaturan Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger d-flex align-items-center">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @else
                    {{-- GUEST BUTTONS --}}
                    <div class="d-flex gap-2 ms-lg-3 mt-3 mt-lg-0">
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-light fw-semibold px-4 rounded-pill border">
                                Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-primary fw-semibold px-4 rounded-pill">
                                Daftar
                            </a>
                        </li>
                    </div>
                @endauth

            </ul>
        </div>
    </div>
</nav>

{{-- CONTENT --}}
<main class="flex-grow-1 py-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
    {{ $slot }}
</main>

{{-- FOOTER --}}
<footer class="py-4 mt-auto">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="text-center text-md-start">
                <span class="fw-bold text-primary">EDVO</span> 
                <span class="text-muted mx-2">|</span> 
                <span class="text-secondary small">&copy; {{ date('Y') }} Education Virtual Online.</span>
            </div>
            <div class="d-flex gap-3">
                <a href="#" class="text-muted text-decoration-none small hover-primary">Privasi</a>
                <a href="#" class="text-muted text-decoration-none small hover-primary">Syarat</a>
                <a href="#" class="text-muted text-decoration-none small hover-primary">Bantuan</a>
            </div>
        </div>
    </div>
</footer>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init AOS with slightly better settings
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
            easing: 'ease-out-cubic',
        });

        // SweetAlert Toast Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#fff',
            color: '#1e293b',
            iconColor: '#0F3D73',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            },
            customClass: {
                popup: 'colored-toast shadow-lg rounded-4 border-0'
            }
        });

        // Flash Messages Logic
        @if(session('success'))
            Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
        @endif

        @if(session('error'))
            Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
        @endif

        @if($errors->any())
            Toast.fire({ icon: 'error', title: 'Periksa kembali inputan Anda', text: "{{ $errors->first() }}" });
        @endif
    });
</script>

@stack('scripts')
</body>
</html>