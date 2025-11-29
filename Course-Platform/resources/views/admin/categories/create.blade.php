<x-app-layout title="Tambah Kategori – Admin">
    <div class="py-4">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h4 mb-1">Tambah Kategori Kursus</h1>
                    <p class="text-muted small mb-0">
                        Kategori membantu mengelompokkan course agar lebih mudah ditemukan oleh pengguna.
                    </p>
                </div>

                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            {{-- CARD FORM --}}
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">

                            {{-- TITLE DI ATAS FORM --}}
                            <div class="mb-4">
                                <h2 class="h5 mb-1">Form Kategori Baru</h2>
                                <p class="text-muted small mb-0">
                                    Lengkapi informasi di bawah ini untuk menambahkan kategori kursus.
                                </p>
                            </div>

                            {{-- FORM --}}
                            <form action="{{ route('admin.categories.store') }}" method="POST" novalidate>
                                @csrf

                                {{-- INPUT: NAMA KATEGORI --}}
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        Nama Kategori <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
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
                                            Beri nama yang singkat dan jelas agar mudah dipahami pengguna.
                                        </div>
                                    @enderror
                                </div>

                                {{-- INPUT: DESKRIPSI --}}
                                <div class="mb-4">
                                    <label for="description" class="form-label">
                                        Deskripsi (opsional)
                                    </label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="4"
                                        class="form-control rounded-3"
                                        placeholder="Deskripsikan kategori ini secara singkat.">
{{ old('description') }}</textarea>
                                    <div class="form-text">
                                        Deskripsi akan membantu pengguna memahami cakupan kategori ini.
                                    </div>
                                </div>

                                {{-- ACTION BUTTONS --}}
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.categories.index') }}"
                                       class="btn btn-light border rounded-3">
                                        Batal
                                    </a>

                                    <button type="submit" class="btn btn-primary rounded-3">
                                        <i class="bi bi-save me-1"></i> Simpan Kategori
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                    {{-- OPTIONAL: INFO KECIL DI BAWAH --}}
                    <p class="text-muted small text-center mt-3 mb-0">
                        Pastikan nama kategori tidak duplikat dengan kategori lain untuk menghindari kebingungan.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
