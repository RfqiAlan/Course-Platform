<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Course
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-2 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Course</h3>
                    <a href="{{ route('courses.manage.create') }}"
                       class="px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Buat Course Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                        <tr class="border-b bg-gray-50 text-xs text-gray-600">
                            <th class="px-3 py-2 text-left">Judul</th>
                            <th class="px-3 py-2 text-left">Pengajar</th>
                            <th class="px-3 py-2 text-left">Kategori</th>
                            <th class="px-3 py-2 text-center">Peserta</th>
                            <th class="px-3 py-2 text-center">Status</th>
                            <th class="px-3 py-2 text-right">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($courses as $course)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-3 py-2 font-medium text-gray-800">
                                    {{ $course->title }}
                                </td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ $course->teacher->name ?? '-' }}
                                </td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ $course->category->name ?? '-' }}
                                </td>
                                <td class="px-3 py-2 text-center text-gray-600">
                                    {{ $course->students()->count() }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-xs
                                        {{ $course->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ strtoupper($course->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-right space-x-1">
                                    <a href="{{ route('courses.manage.edit', $course) }}"
                                       class="inline-flex px-3 py-1 text-xs rounded-lg border border-gray-300 hover:bg-gray-50">
                                        Edit
                                    </a>
                                    <form action="{{ route('courses.manage.destroy', $course) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Yakin ingin menghapus course ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex px-3 py-1 text-xs rounded-lg bg-red-600 text-white hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
