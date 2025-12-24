<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Panel' }} – {{ config('app.name', 'EDVO') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --topbar-height: 60px;
            --primary-color: #0F3D73;
            --primary-dark: #0a2d54;
            --sidebar-bg: linear-gradient(180deg, #0F3D73 0%, #0a2d54 100%);
        }

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #f1f5f9;
            overflow-x: hidden;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1040;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .admin-sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-brand {
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
        }

        .sidebar-brand-text {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .admin-sidebar.collapsed .sidebar-brand-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0.75rem;
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-title {
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0 0.75rem;
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
        }

        .admin-sidebar.collapsed .nav-section-title {
            text-align: center;
            padding: 0;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 0.75rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 0.25rem;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .sidebar-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .sidebar-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-weight: 600;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-link-text {
            transition: opacity 0.3s;
        }

        .admin-sidebar.collapsed .sidebar-link-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .admin-sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding: 0.7rem;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
            transition: opacity 0.3s;
        }

        .admin-sidebar.collapsed .sidebar-user-info {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar-user-name {
            color: #fff;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            color: rgba(255,255,255,0.6);
            font-size: 0.7rem;
        }

        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .admin-sidebar.collapsed ~ .admin-main {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Topbar */
        .admin-topbar {
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: #64748b;
            font-size: 1.25rem;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .sidebar-toggle:hover {
            background: #f1f5f9;
            color: var(--primary-color);
        }

        .topbar-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .topbar-btn {
            background: none;
            border: none;
            color: #64748b;
            font-size: 1.1rem;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }

        .topbar-btn:hover {
            background: #f1f5f9;
            color: var(--primary-color);
        }

        .topbar-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        /* Content Area */
        .admin-content {
            padding: 1.5rem;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1035;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-sidebar.show ~ .sidebar-overlay {
                display: block;
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-sidebar.collapsed ~ .admin-main {
                margin-left: 0;
            }
        }

        /* Dropdown User in Topbar */
        .user-dropdown .dropdown-toggle::after {
            display: none;
        }

        .user-dropdown .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            border-radius: 12px;
            padding: 0.5rem;
            min-width: 200px;
        }

        .user-dropdown .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
        }

        .user-dropdown .dropdown-item:hover {
            background: #f1f5f9;
        }

        .user-dropdown .dropdown-item i {
            width: 20px;
        }
    </style>

    @stack('styles')
</head>
<body>

@php
    $user = auth()->user();
@endphp

<!-- Sidebar -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('logo/logo.jpeg') }}" alt="EDVO">
        <span class="sidebar-brand-text">EDVO Admin</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span class="sidebar-link-text">Dashboard</span>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Manajemen</div>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span class="sidebar-link-text">Pengguna</span>
            </a>
            <a href="{{ route('admin.courses.index') }}" class="sidebar-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span class="sidebar-link-text">Kursus</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i>
                <span class="sidebar-link-text">Kategori</span>
            </a>
        </div>


    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ $user->name ?? 'Admin' }}</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Main Content -->
<div class="admin-main">
    <!-- Topbar -->
    <header class="admin-topbar">
        <div class="topbar-left">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-title">{{ $title ?? 'Dashboard' }}</span>
        </div>

        <div class="topbar-right">
            <button class="topbar-btn" title="Notifikasi">
                <i class="bi bi-bell"></i>
                <span class="topbar-badge"></span>
            </button>

            <div class="dropdown user-dropdown">
                <button class="topbar-btn dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-semibold small">{{ $user->name ?? 'Admin' }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ $user->email ?? '' }}</div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-gear me-2"></i>Profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="admin-content">
        {{ $slot }}
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({ once: true, duration: 600 });

    const sidebar = document.getElementById('adminSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    // Toggle sidebar
    sidebarToggle.addEventListener('click', function() {
        if (window.innerWidth < 992) {
            sidebar.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');
        }
    });

    // Close sidebar on overlay click (mobile)
    sidebarOverlay.addEventListener('click', function() {
        sidebar.classList.remove('show');
    });

    // Handle resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('show');
        }
    });

    // Toast notifications
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        background: '#fff',
        color: '#1e293b',
        customClass: { 
            popup: 'shadow-lg border-0',
            title: 'fw-semibold',
            timerProgressBar: 'bg-primary'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    @if(session('success'))
        Toast.fire({ 
            icon: 'success',
            iconColor: '#22c55e',
            title: 'Berhasil!',
            html: '<span class="text-muted small">{{ session("success") }}</span>'
        });
    @endif

    @if(session('error'))
        Toast.fire({ 
            icon: 'error',
            iconColor: '#ef4444',
            title: 'Terjadi Kesalahan',
            html: '<span class="text-muted small">{{ session("error") }}</span>'
        });
    @endif

    @if($errors->any())
        Toast.fire({ 
            icon: 'warning',
            iconColor: '#f59e0b',
            title: 'Validasi Gagal',
            html: '<span class="text-muted small">{{ $errors->first() }}</span>'
        });
    @endif
});
</script>

@stack('scripts')
</body>
</html>
