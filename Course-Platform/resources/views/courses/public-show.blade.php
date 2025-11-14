<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Course
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-2 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-2 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl p-6 space-y-4">
                <div class="flex flex-col gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-blue-50 text-blue-700 w-fit">
                        {{ $course->category->name ?? 'Umum' }}
                    </span>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ $course->title }}
                    </h1>
                    <p class="text-sm text-gray-500">
                        Pengajar: {{ $course->teacher->name ?? '-' }}
                    </p>
                </div>

                <p class="text-gray-700 text-sm leading-relaxed">
                    {{ $course->description }}
                </p>

                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
                    <span>Status: <span class="font-semibold">{{ strtoupper($course->status) }}</span></span>
                    <span>Jumlah materi: {{ $course->contents->count() }}</span>
                    <span>Peserta: {{ $course->students()->count() }}</span>
                </div>

                @auth
                    @if (auth()->user()->isStudent())
                        @php
                            $enrolled = auth()->user()
                                ->enrolledCourses()
                                ->where('course_id', $course->id)
                                ->exists();
                            $firstContent = $course->contents->sortBy('order')->first();
                        @endphp

                        <div class="pt-4 border-t border-gray-100 flex gap-3">
                            @if (! $enrolled)
                                <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                                        Ikuti Course Ini
                                    </button>
                                </form>
                            @elseif($firstContent)
                                <a href="{{ route('lessons.show', [$course->id, $firstContent->id]) }}"
                                   class="px-4 py-2 text-sm font-semibold rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                                    Lanjutkan Belajar
                                </a>
                            @endif
                        </div>
                    @endif
                @else
                    <p class="text-xs text-gray-500 pt-3 border-t">
                        Silakan <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a>
                        sebagai siswa untuk mengikuti course.
                    </p>
                @endauth
            </div>

            <div class="bg-white shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Daftar Materi</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    @forelse($course->contents as $content)
                        <li class="flex items-center gap-2">
                            <span class="w-6 text-xs text-gray-500">{{ $content->order }}.</span>
                            <span>{{ $content->title }}</span>
                        </li>
                    @empty
                        <li class="text-gray-500 text-sm">Belum ada materi.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
