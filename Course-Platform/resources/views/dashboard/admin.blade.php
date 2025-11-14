<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-2 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 md:grid-cols-4">
                <div class="bg-white shadow-sm rounded-xl p-4">
                    <p class="text-xs text-gray-500">Total User</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ \App\Models\User::count() }}
                    </p>
                </div>
                <div class="bg-white shadow-sm rounded-xl p-4">
                    <p class="text-xs text-gray-500">Total Course</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ \App\Models\Course::count() }}
                    </p>
                </div>
                <div class="bg-white shadow-sm rounded-xl p-4">
                    <p class="text-xs text-gray-500">Kategori</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ \App\Models\Category::count() }}
                    </p>
                </div>
                <div class="bg-white shadow-sm rounded-xl p-4">
                    <p class="text-xs text-gray-500">Enrollment</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ \Illuminate\Support\Facades\DB::table('course_user')->count() }}
                    </p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-6 space-y-3">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Menu Cepat</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('users.index') }}"
                       class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                        Kelola User
                    </a>
                    <a href="{{ route('categories.index') }}"
                       class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                        Kelola Kategori
                    </a>
                    <a href="{{ route('courses.manage.index') }}"
                       class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700">
                        Kelola Course
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
