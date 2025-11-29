<x-app-layout title="Kategori – Admin">
    <div class="py-4">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h4 mb-1">Kategori Kursus</h1>
                    <p class="text-muted small mb-0">
                        Kelola kategori yang digunakan untuk mengelompokkan course di platform.
                    </p>
                </div>

                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
                </a>
            </div>

            {{-- CARD LIST --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">

                    {{-- ALERT --}}
                    @if(session('success'))
                        <div class="alert alert-success border-0 small d-flex align-items-center mb-3">
                            <i class="bi bi-check-circle me-2"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- TABLE --}}
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Nama Kategori</th>
                                    <th class="text-end" style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration + ($categories->firstItem() - 1) }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $category->name }}</div>
                                            @if($category->description)
                                                <div class="text-muted small">
                                                    {{ Str::limit($category->description, 80) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                               class="btn btn-outline-secondary btn-sm me-1"
                                               title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Hapus kategori \"{{ $category->name }}\"?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-sm"
                                                        title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <div class="mb-2">
                                                <i class="bi bi-folder2-open" style="font-size: 2rem;"></i>
                                            </div>
                                            <div class="fw-semibold mb-1">Belum ada kategori</div>
                                            <p class="small mb-2">
                                                Mulai dengan menambahkan kategori baru untuk mengelompokkan course.
                                            </p>
                                            <a href="{{ route('admin.categories.create') }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    @if($categories->hasPages())
                        <div class="mt-3">
                            {{ $categories->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
