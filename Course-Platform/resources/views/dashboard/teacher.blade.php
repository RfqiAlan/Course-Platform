<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pengajar
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-2 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl p-6 space-y-4">
                <p class="text-gray-700">
                    Hai, <span class="font-semibold">{{ auth()->user()->name }}</span> 👋  
                    Kelola course dan materi pembelajaranmu di sini.
                </p>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="border border-gray-200 rounded-xl p-4">
                        <p class="text-xs text-gray-500">Course yang Anda ajar</p>
                        <p class="text-2xl font-bold mt-1">
                            {{ \App\Models\Course::where('teacher_id', auth()->id())->count() }}
                        </p>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-4">
                        <p class="text-xs text-gray-500">Materi yang dibuat</p>
                        <p class="text-2xl font-bold mt-1">
                            {{ \App\Models\Content::where('teacher_id', auth()->id())->count() }}
                        </p>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-4">
                        <p class="text-xs text-gray-500">Total Peserta</p>
                        <p class="text-2xl font-bold mt-1">
                            {{ \Illuminate\Support\Facades\DB::table('course_user')
                                ->join('courses','courses.id','=','course_user.course_id')
                                ->where('courses.teacher_id', auth()->id())
                                ->count() }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('courses.manage.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                        Buat Course Baru
                    </a>
                    <a href="{{ route('contents.create') }}"
                       class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                        Tambah Materi
                    </a>
                    <a href="{{ route('courses.manage.index') }}"
                       class="px-4 py-2 border border-gray-300 text-sm rounded-lg hover:bg-gray-50">
                        Lihat Semua Course
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
