<x-app-layout :title="'Edit Kategori – '.$category->name">
    <div class="py-4">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h4 mb-1">Edit Kategori Kursus</h1>
                    <p class="text-muted small mb-0">
                        Perbarui nama dan deskripsi kategori agar tetap relevan.
                    </p>
                </div>

                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">

                            <div class="mb-4">
                                <h2 class="h5 mb-1">Form Edit Kategori</h2>
                                <p class="text-muted small mb-0">
                                    Sesuaikan informasi kategori tanpa mengubah struktur kursus yang sudah ada.
                                </p>
                            </div>

                            <form action="{{ route('admin.categories.update', $category) }}"
                                  method="POST"
                                  novalidate>
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        Nama Kategori <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $category->name) }}"
                                        class="form-control rounded-3 @error('name') is-invalid @enderror"
                                        placeholder="Contoh: Pemrograman, Matematika, Desain UI"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @else
                                        <div class="form-text">
                                            Gunakan nama yang singkat, jelas, dan tidak duplikat dengan kategori lain.
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label">
                                        Deskripsi (opsional)
                                    </label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="4"
                                        class="form-control rounded-3"
                                        placeholder="Tambahkan penjelasan singkat mengenai kategori ini.">{{ old('description', $category->description) }}</textarea>
                                    <div class="form-text">
                                        Deskripsi akan membantu pengguna memahami cakupan kategori.
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.categories.index') }}"
                                       class="btn btn-light border rounded-3">
                                        Batal
                                    </a>

                                    <button type="submit" class="btn btn-primary rounded-3">
                                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <p class="text-muted small text-center mt-3 mb-0">
                        Perubahan nama kategori tidak akan menghapus kursus yang sudah terhubung.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
