<x-app-layout title="Kategori – Admin">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h5 mb-1">Kategori Kursus</h1>
                <p class="small text-muted mb-0">Kelola kategori course.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success small">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration + ($categories->firstItem() - 1) }}</td>
                                <td>{{ $category->name }}</td>
                                <td class="text-muted">{{ $category->slug }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.categories.edit',$category) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy',$category) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Belum ada kategori.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
