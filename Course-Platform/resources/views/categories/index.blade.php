<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Kategori
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-2 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Kategori</h3>
                    <a href="{{ route('categories.create') }}"
                       class="px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Tambah Kategori
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="px-3 py-2 text-left font-medium text-gray-600">Nama</th>
                            <th class="px-3 py-2 text-left font-medium text-gray-600">Deskripsi</th>
                            <th class="px-3 py-2 text-right font-medium text-gray-600">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $category)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-3 py-2 font-medium text-gray-800">{{ $category->name }}</td>
                                <td class="px-3 py-2 text-gray-600">
                                    {{ \Illuminate\Support\Str::limit($category->description, 80) }}
                                </td>
                                <td class="px-3 py-2 text-right space-x-1">
                                    <a href="{{ route('categories.edit', $category) }}"
                                       class="inline-flex items-center px-3 py-1 text-xs rounded-lg border border-gray-300 hover:bg-gray-50">
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1 text-xs rounded-lg bg-red-600 text-white hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-3 text-center text-gray-500">
                                    Belum ada kategori.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
