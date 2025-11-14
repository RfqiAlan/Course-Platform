<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Siswa
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-2 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl p-6 space-y-3">
                <p class="text-gray-700">
                    Hai, <span class="font-semibold">{{ auth()->user()->name }}</span> 👋  
                    Lanjutkan course yang sedang kamu ikuti.
                </p>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Course yang Diikuti</h3>
                    <a href="{{ route('courses.public.index') }}"
                       class="text-sm text-blue-600 hover:underline">
                        Cari course lain
                    </a>
                </div>

                @php
                    $courses = auth()->user()
                        ->enrolledCourses()
                        ->with('contents')
                        ->get();
                @endphp

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($courses as $course)
                        @php
                            $total = $course->contents->count();
                            $done  = \Illuminate\Support\Facades\DB::table('content_user')
                                        ->where('user_id', auth()->id())
                                        ->whereIn('content_id', $course->contents->pluck('id'))
                                        ->where('is_done', true)
                                        ->count();
                            $progress = $total > 0 ? intval($done / max($total,1) * 100) : 0;
                            $firstContent = $course->contents->sortBy('order')->first();
                        @endphp

                        <div class="border border-gray-200 rounded-xl p-4 flex flex-col gap-3">
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $course->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $course->teacher->name ?? '-' }}</p>
                            </div>

                            <div class="mt-1">
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <span>Progres</span>
                                    <span>{{ $progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-blue-600"
                                         style="width: {{ $progress }}%"></div>
                                </div>
                            </div>

                            @if ($firstContent)
                                <a href="{{ route('lessons.show', [$course->id, $firstContent->id]) }}"
                                   class="mt-auto inline-flex justify-center px-4 py-2 text-xs font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                                    Lanjutkan Belajar
                                </a>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">
                            Kamu belum mengikuti course apapun.  
                            <a href="{{ route('courses.public.index') }}" class="text-blue-600 hover:underline">
                                Mulai cari course sekarang.
                            </a>
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
