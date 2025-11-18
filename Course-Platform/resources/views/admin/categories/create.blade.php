<x-app-layout title="Tambah Kategori – Admin">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Tambah Kategori Kursus</h1>
            <p class="small text-muted mb-0">
                Kategori membantu mengelompokkan course agar lebih mudah dicari.
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label class="form-label small">Nama Kategori</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control form-control-sm @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">Slug (opsional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                               class="form-control form-control-sm @error('slug') is-invalid @enderror">
                        @error('slug') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        <div class="form-text small">
                            Biarkan kosong untuk dibuat otomatis dari nama.
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small">Deskripsi (opsional)</label>
                        <textarea name="description" rows="3"
                                  class="form-control form-control-sm">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-sm">
                            Batal
                        </a>
                        <button class="btn btn-primary btn-sm">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
