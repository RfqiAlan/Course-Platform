<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'EDVO')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind + JS dari Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons (hanya untuk icon, tidak pakai CSS layoutnya) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- AOS (Animate On Scroll) --}}
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    {{-- Alpine.js untuk mobile navbar --}}
    <script src="https://unpkg.com/alpinejs" defer></script>

    <style>
        :root {
            /* Warna brand */
            --brand-primary: #0F3D73;
        }

        body{
            background: linear-gradient(180deg,#e7f2ff 0%,#f8fbff 40%,#ffffff 100%);
            min-height:100vh;
            font-family: system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen text-slate-900 flex flex-col">

{{-- NAVBAR --}}
<header
    class="sticky top-0 z-30 border-b border-slate-100 bg-white/90 backdrop-blur"
    data-aos="fade-down"
    data-aos-duration="500"
    x-data="{ open:false }"
>
    <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-14 items-center justify-between">
            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#0F3D73]/10">
                    <i class="bi bi-mortarboard-fill text-xl" style="color:#0F3D73"></i>
                </span>
                <div class="flex flex-col">
                </div>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden items-center gap-6 md:flex">
                <a href="{{ route('home') }}"
                   class="text-sm font-medium transition-colors
                          {{ request()->routeIs('home')
                                ? 'text-[#0F3D73]'
                                : 'text-slate-600 hover:text-[#0F3D73]' }}">
                    Beranda
                </a>

                <a href="{{ route('courses.index') }}"
                   class="text-sm font-medium transition-colors
                          {{ request()->routeIs('courses.*')
                                ? 'text-[#0F3D73]'
                                : 'text-slate-600 hover:text-[#0F3D73]' }}">
                    Kursus
                </a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="relative" x-data="{ openMenu:false }">
                            <button
                                @click="openMenu = !openMenu"
                                class="inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-[#0F3D73] transition"
                            >
                                Admin
                                <i class="bi bi-chevron-down text-[10px] mt-[1px]"></i>
                            </button>
                            <div
                                x-cloak
                                x-show="openMenu"
                                @click.outside="openMenu=false"
                                x-transition
                                class="absolute right-0 mt-2 w-44 rounded-xl border border-slate-100 bg-white shadow-lg text-sm py-1 z-40"
                            >
                                <a href="{{ route('admin.users.index') }}"
                                   class="block px-3 py-2 text-slate-600 hover:bg-slate-50">
                                    Manajemen User
                                </a>
                                <a href="{{ route('admin.categories.index') }}"
                                   class="block px-3 py-2 text-slate-600 hover:bg-slate-50">
                                    Kategori
                                </a>
                                <a href="{{ route('admin.courses.index') }}"
                                   class="block px-3 py-2 text-slate-600 hover:bg-slate-50">
                                    Course
                                </a>
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->isTeacher())
                        <a href="{{ route('teacher.courses.index') }}"
                           class="text-sm font-medium text-slate-600 hover:text-[#0F3D73] transition">
                            Kursus Saya
                        </a>
                    @endif

                    @if(auth()->user()->isStudent())
                        <a href="{{ route('courses.index') }}?my=1"
                           class="text-sm font-medium text-slate-600 hover:text-[#0F3D73] transition">
                            Kursus Diikuti
                        </a>
                    @endif

                    {{-- Profile dropdown --}}
                    <div class="relative" x-data="{ openProfile:false }">
                        <button
                            @click="openProfile = !openProfile"
                            class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-2.5 py-1 text-xs font-medium text-slate-700 hover:border-[#0F3D73]/60 hover:text-[#0F3D73] transition"
                        >
                            <i class="bi bi-person-circle text-base"></i>
                            <span class="hidden md:inline-block max-w-[120px] truncate">
                                {{ auth()->user()->name }}
                            </span>
                            <i class="bi bi-chevron-down text-[9px] mt-[1px]"></i>
                        </button>
                        <div
                            x-cloak
                            x-show="openProfile"
                            @click.outside="openProfile=false"
                            x-transition
                            class="absolute right-0 mt-2 w-44 rounded-xl border border-slate-100 bg-white shadow-lg text-sm py-1 z-40"
                        >
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-2 px-3 py-2 text-slate-600 hover:bg-slate-50">
                                <i class="bi bi-gear text-slate-500"></i>
                                <span>Profil</span>
                            </a>
                            <div class="my-1 border-t border-slate-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    class="flex w-full items-center gap-2 px-3 py-2 text-red-600 hover:bg-red-50 text-left"
                                    type="submit"
                                >
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-[#0F3D73] border border-[#0F3D73]/40 px-3 py-1.5 rounded-lg hover:bg-[#0F3D73]/5 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-sm font-semibold text-white px-3 py-1.5 rounded-lg shadow-sm"
                       style="background-color:#0F3D73">
                        Daftar
                    </a>
                @endguest
            </div>

            {{-- Mobile toggle --}}
            <button
                class="inline-flex items-center justify-center rounded-md p-1.5 text-slate-600 md:hidden"
                @click="open = !open"
            >
                <span class="sr-only">Toggle navigation</span>
                <i class="bi" :class="open ? 'bi-x-lg' : 'bi-list'"></i>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div
            class="md:hidden"
            x-cloak
            x-show="open"
            x-transition
        >
            <div class="border-t border-slate-100 py-2 space-y-1 text-sm">
                <a href="{{ route('home') }}"
                   class="block px-2 py-1.5 rounded-md
                          {{ request()->routeIs('home')
                                ? 'bg-[#0F3D73]/5 text-[#0F3D73] font-semibold'
                                : 'text-slate-600 hover:bg-slate-50' }}">
                    Beranda
                </a>

                <a href="{{ route('courses.index') }}"
                   class="block px-2 py-1.5 rounded-md
                          {{ request()->routeIs('courses.*')
                                ? 'bg-[#0F3D73]/5 text-[#0F3D73] font-semibold'
                                : 'text-slate-600 hover:bg-slate-50' }}">
                    Kursus
                </a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="pt-1">
                            <p class="px-2 text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                Admin
                            </p>
                            <a href="{{ route('admin.users.index') }}" class="block px-2 py-1.5 text-slate-600 hover:bg-slate-50 rounded-md">
                                Manajemen User
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="block px-2 py-1.5 text-slate-600 hover:bg-slate-50 rounded-md">
                                Kategori
                            </a>
                            <a href="{{ route('admin.courses.index') }}" class="block px-2 py-1.5 text-slate-600 hover:bg-slate-50 rounded-md">
                                Course
                            </a>
                        </div>
                    @endif

                    @if(auth()->user()->isTeacher())
                        <a href="{{ route('teacher.courses.index') }}"
                           class="block px-2 py-1.5 text-slate-600 hover:bg-slate-50 rounded-md">
                            Kursus Saya
                        </a>
                    @endif

                    @if(auth()->user()->isStudent())
                        <a href="{{ route('courses.index') }}?my=1"
                           class="block px-2 py-1.5 text-slate-600 hover:bg-slate-50 rounded-md">
                            Kursus Diikuti
                        </a>
                    @endif

                    <div class="border-t border-slate-100 mt-2 pt-2">
                        <div class="flex items-center gap-2 px-2 pb-1">
                            <i class="bi bi-person-circle text-base text-slate-500"></i>
                            <span class="text-xs font-medium text-slate-700 truncate max-w-[160px]">
                                {{ auth()->user()->name }}
                            </span>
                        </div>
                        <a href="{{ route('profile.edit') }}"
                           class="block px-2 py-1.5 text-slate-600 hover:bg-slate-50 rounded-md text-sm">
                            Pengaturan Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full text-left px-2 py-1.5 text-sm text-red-600 hover:bg-red-50 rounded-md"
                            >
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth

                @guest
                    <div class="flex gap-2 px-2 pt-1">
                        <a href="{{ route('login') }}"
                           class="flex-1 text-center text-xs font-medium text-[#0F3D73] border border-[#0F3D73]/40 px-3 py-1.5 rounded-lg hover:bg-[#0F3D73]/5 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="flex-1 text-center text-xs font-semibold text-white px-3 py-1.5 rounded-lg shadow-sm"
                           style="background-color:#0F3D73">
                            Daftar
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
</header>

{{-- MAIN CONTENT --}}
<main class="flex-1 py-4" data-aos="fade-up" data-aos-duration="600" data-aos-easing="ease-out-cubic">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        @yield('content')
    </div>
</main>

<footer class="border-t border-slate-100 py-3" data-aos="fade-up" data-aos-duration="500">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-500">
        <span>&copy; {{ date('Y') }} EDVO – EDUCATION VIRTUAL ONLINE.</span>
        <span>Made with <span class="text-red-500">&hearts;</span> & Tailwind CSS.</span>
    </div>
</footer>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- AOS JS --}}
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init AOS
        AOS.init({
            once: true,
            duration: 600,
            easing: 'ease-out-cubic'
        });

        // Konfigurasi toast snackbar di kanan atas
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2600,
            timerProgressBar: true,
            customClass: {
                popup: 'shadow-sm rounded-md'
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
