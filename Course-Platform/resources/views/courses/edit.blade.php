<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Course
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6">

                <form method="POST" action="{{ route('courses.manage.update', $course) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Course</label>
                        <input type="text" name="title" value="{{ old('title', $course->title) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="4"
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">{{ old('description', $course->description) }}</textarea>
                        @error('description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if (auth()->user()->isAdmin())
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pengajar</label>
                                <select name="teacher_id"
                                        class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            @selected(old('teacher_id', $course->teacher_id) == $teacher->id)>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select name="category_id"
                                        class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                                    <option value="">-- Tanpa kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            @selected(old('category_id', $course->category_id) == $cat->id)>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="category_id"
                                    class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                                <option value="">-- Tanpa kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        @selected(old('category_id', $course->category_id) == $cat->id)>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date"
                                   value="{{ old('start_date', optional($course->start_date)->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                            @error('start_date')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" name="end_date"
                                   value="{{ old('end_date', optional($course->end_date)->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                            @error('end_date')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                    class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                                <option value="active" @selected(old('status', $course->status) == 'active')>Active</option>
                                <option value="inactive" @selected(old('status', $course->status) == 'inactive')>Inactive</option>
                            </select>
                            @error('status')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('courses.manage.index') }}"
                           class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
