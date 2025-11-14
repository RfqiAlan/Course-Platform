{{-- resources/views/home.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Platform Kursus Daring
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Hero Section --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="space-y-2">
                        <h1 class="text-3xl font-bold text-gray-900">
                            Belajar dari mana saja, kapan saja.
                        </h1>
                        <p class="text-gray-600">
                            Jelajahi berbagai course dari pengajar terbaik dan pantau progres belajarmu secara terstruktur.
                        </p>
                        <div class="flex flex-wrap gap-3 mt-3">
                            @guest
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700">
                                    Daftar sekarang
                                </a>
                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold border border-gray-300 text-gray-700 hover:bg-gray-50">
                                    Masuk
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                   class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700">
                                    Buka Dashboard
                                </a>
                            @endguest
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                            <p class="text-sm text-blue-700 font-medium mb-2">
                                Course Terpopuler Minggu Ini
                            </p>
                            <ul class="space-y-2 text-sm text-gray-700">
                                @forelse($popularCourses as $course)
                                    <li class="flex items-center justify-between">
                                        <span class="line-clamp-1">{{ $course->title }}</span>
                                        <span class="text-xs text-gray-500">{{ $course->students_count }} peserta</span>
                                    </li>
                                @empty
                                    <li>Tidak ada course populer untuk saat ini.</li>
                                @endforelse
                            </ul>
                            <div class="mt-3">
                                <a href="{{ route('courses.public.index') }}"
                                   class="text-xs font-medium text-blue-600 hover:underline">
                                    Lihat semua course →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card List 5 Course Terpopuler --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Course Terpopuler
                    </h3>
                    <a href="{{ route('courses.public.index') }}"
                       class="text-sm text-blue-600 hover:underline">
                        Jelajahi semua course
                    </a>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($popularCourses as $course)
                        <div class="border border-gray-200 rounded-xl p-4 flex flex-col justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">
                                    {{ $course->title }}
                                </h4>
                                <p class="text-xs text-gray-500 mb-2">
                                    {{ $course->category->name ?? 'Umum' }} ·
                                    {{ $course->teacher->name ?? '-' }}
                                </p>
                                <p class="text-sm text-gray-600 line-clamp-3">
                                    {{ \Illuminate\Support\Str::limit($course->description, 120) }}
                                </p>
                            </div>
                            <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                                <span>{{ $course->students_count }} peserta</span>
                                <a href="{{ route('courses.public.show',$course) }}"
                                   class="text-blue-600 font-medium hover:underline">
                                    Lihat detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada course aktif.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
