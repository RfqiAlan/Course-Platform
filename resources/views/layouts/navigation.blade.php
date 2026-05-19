<nav x-data="{ open: false }"
     class="bg-white/95 backdrop-blur-xl border-b border-slate-100 shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            @php
                /** @var \App\Models\User|null $user */
                $user = auth()->user();
            @endphp

            {{-- ===================================== --}}
            {{-- LEFT: LOGO + BRAND + MAIN NAV (DESKTOP) --}}
            {{-- ===================================== --}}
            <div class="flex items-center gap-8">

                {{-- LOGO + BRAND --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="relative">
                        <img src="{{ asset('logo/logo.jpeg') }}"
                             alt="Logo"
                             class="h-9 w-9 rounded-2xl object-cover shadow-sm ring-1 ring-slate-200/70">
                        <span class="pointer-events-none absolute -right-1 -bottom-1 inline-flex h-3 w-3 items-center justify-center rounded-full bg-emerald-500 ring-2 ring-white">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-100"></span>
                        </span>
                    </div>
                    <div class="hidden sm:flex flex-col leading-tight">
                        <span class="font-semibold text-sm tracking-tight text-slate-900">
                            {{ config('app.name', 'EDVO') }}
                        </span>
                        <span class="text-[11px] text-slate-500">
                            Smart Learning Platform
                        </span>
                    </div>
                </a>

                {{-- MAIN LINKS (DESKTOP) --}}
                <div class="hidden sm:flex items-center gap-1 rounded-full bg-slate-50/80 px-1.5 py-1 ring-1 ring-slate-100">

                    {{-- ===== BERANDA (AUTH / GUEST) ===== --}}
                    @if($user)
                        @php
                            $isHomeActive = request()->routeIs([
                                'home',
                                'dashboard',
                                'student.dashboard',
                                'teacher.dashboard',
                                'admin.dashboard',
                            ]);
                        @endphp
                        <a href="{{ route('dashboard') }}"
                           class="relative inline-flex items-center rounded-full px-3 py-1.5 text-xs font-medium transition
                                  {{ $isHomeActive
                                        ? 'bg-slate-900 text-white shadow-sm'
                                        : 'text-slate-600 hover:text-slate-900 hover:bg-white/70' }}">
                            <span>Beranda</span>
                        </a>
                    @else
                        @php
                            $isHomeActive = request()->routeIs('home');
                        @endphp
                        <a href="{{ route('home') }}"
                           class="relative inline-flex items-center rounded-full px-3 py-1.5 text-xs font-medium transition
                                  {{ $isHomeActive
                                        ? 'bg-slate-900 text-white shadow-sm'
                                        : 'text-slate-600 hover:text-slate-900 hover:bg-white/70' }}">
                            <span>Beranda</span>
                        </a>
                    @endif

                    {{-- ===== KURSUS (PUBLIK / STUDENT) ===== --}}

                    {{-- Guest → Katalog /courses --}}
                    @guest
                        @php
                            $isCatalogActive = request()->routeIs('courses.*');
                        @endphp
                        <a href="{{ route('courses.index') }}"
                           class="relative inline-flex items-center rounded-full px-3 py-1.5 text-xs font-medium transition
                                  {{ $isCatalogActive
                                        ? 'bg-slate-900 text-white shadow-sm'
                                        : 'text-slate-600 hover:text-slate-900 hover:bg-white/70' }}">
                            <span>Kursus</span>
                        </a>
                    @endguest

                    {{-- Student → Kursus diikuti --}}
                    @auth
                        @if($user && ($user->role === 'student' || (method_exists($user,'isStudent') && $user->isStudent())))
                            @php
                                $isStudentCourseActive = request()->routeIs('student.courses.*');
                            @endphp
                            <a href="{{ route('student.courses.index') }}"
                               class="relative inline-flex items-center rounded-full px-3 py-1.5 text-xs font-medium transition
                                      {{ $isStudentCourseActive
                                            ? 'bg-slate-900 text-white shadow-sm'
                                            : 'text-slate-600 hover:text-slate-900 hover:bg-white/70' }}">
                                <span>Kursus Saya</span>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex items-center gap-4">

                @auth
                    @if($user)
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-indigo-100 bg-indigo-50/80 px-3 py-1 text-[11px] font-medium text-indigo-700">
                            <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            {{ ucfirst($user->role) }}
                        </span>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center rounded-full border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="hidden md:inline-flex items-center rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:from-indigo-600 hover:to-purple-600 transition">
                        Mulai Belajar
                    </a>
                @endguest

     
                @auth
        
                    @if($user->role === 'student' || (method_exists($user,'isStudent') && $user->isStudent()))
                        <a href="{{ route('student.courses.index') }}"
                           class="hidden md:inline-flex items-center rounded-full bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-black transition">
                            Lanjutkan Belajar
                        </a>
                    @endif

           
                    @if($user->role === 'teacher')
                        <a href="{{ route('teacher.dashboard') }}"
                           class="hidden md:inline-flex items-center rounded-full bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                            Panel Pengajar
                        </a>
                    @endif

                    @if($user->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="hidden md:inline-flex items-center rounded-full bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-rose-700 transition">
                            Admin Panel
                        </a>

                        <a href="{{ route('teacher.dashboard') }}"
                           class="hidden md:inline-flex items-center rounded-full bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                            Kelola Materi
                        </a>
                    @endif
                @endauth

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-2.5 py-1.5 text-sm font-medium text-slate-600 shadow-sm hover:border-slate-300 hover:text-slate-900 focus:outline-none transition">

                                <div class="flex items-center gap-2">
                                    <div
                                        class="flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-[11px] font-semibold text-white">
                                        {{ strtoupper(mb_substr($user->name,0,1,'UTF-8')) }}
                                    </div>
                                    <span class="hidden max-w-[140px] truncate md:inline-block">
                                        {{ $user->name }}
                                    </span>
                                </div>

                                <svg class="h-4 w-4 text-slate-400"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                          clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="border-b border-slate-100 px-3 pt-2 pb-2">
                                <p class="truncate text-xs font-semibold text-slate-800">
                                    {{ $user->name }}
                                </p>
                                <p class="truncate text-[11px] text-slate-500">
                                    {{ $user->email }}
                                </p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 focus:bg-slate-100 focus:text-slate-700 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': ! open }"
         class="hidden border-t border-slate-100 bg-white sm:hidden">

        @auth
            <div class="px-4 pt-3 pb-2">
                <div class="mb-3 flex items-center gap-3">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-sm font-semibold text-white">
                        {{ strtoupper(mb_substr($user->name,0,1,'UTF-8')) }}
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-900">{{ $user->name }}</div>
                        <div class="text-xs text-slate-500">{{ $user->email }}</div>
                        <div class="mt-1 inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-2 py-0.5 text-[11px] font-medium text-indigo-700">
                            {{ ucfirst($user->role) }}
                        </div>
                    </div>
                </div>
            </div>
        @endauth

        <div class="space-y-1 border-t border-slate-100 px-2 pb-3 pt-1">

            @auth
                <x-responsive-nav-link
                    :href="route('dashboard')"
                    :active="
                        request()->routeIs('home')
                        || request()->routeIs('dashboard')
                        || request()->routeIs('student.dashboard')
                        || request()->routeIs('teacher.dashboard')
                        || request()->routeIs('admin.dashboard')
                    "
                >
                    {{ __('Beranda') }}
                </x-responsive-nav-link>
            @endauth

            @guest
                <x-responsive-nav-link
                    :href="route('home')"
                    :active="request()->routeIs('home')"
                >
                    {{ __('Beranda') }}
                </x-responsive-nav-link>
            @endguest

            @guest
                <x-responsive-nav-link
                    :href="route('courses.index')"
                    :active="request()->routeIs('courses.*')"
                >
                    {{ __('Kursus') }}
                </x-responsive-nav-link>
            @endguest

            @auth
                @if($user->role === 'student' || (method_exists($user,'isStudent') && $user->isStudent()))
                    <x-responsive-nav-link
                        :href="route('student.courses.index')"
                        :active="request()->routeIs('student.courses.*')"
                    >
                        {{ __('Kursus Saya') }}
                    </x-responsive-nav-link>
                @endif

                @if($user->role === 'teacher')
                    <x-responsive-nav-link
                        :href="route('teacher.dashboard')"
                        :active="request()->routeIs('teacher.*')"
                    >
                        {{ __('Panel Pengajar') }}
                    </x-responsive-nav-link>
                @endif

                @if($user->role === 'admin')
                    <x-responsive-nav-link
                        :href="route('admin.dashboard')"
                        :active="request()->routeIs('admin.*')"
                    >
                        {{ __('Admin Panel') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link
                        :href="route('teacher.dashboard')"
                        :active="request()->routeIs('teacher.*')"
                    >
                        {{ __('Kelola Materi') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        @auth
            <div class="border-t border-slate-100 px-2 pb-3 pt-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        @endauth

        @guest
            <div class="border-t border-slate-100 px-2 pb-3 pt-2 flex gap-2">
                <a href="{{ route('login') }}"
                   class="flex-1 inline-flex items-center justify-center rounded-full border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="flex-1 inline-flex items-center justify-center rounded-full bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700 transition">
                    Daftar
                </a>
            </div>
        @endguest
    </div>
</nav>
