<x-app-layout title="Tambah User – Admin">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Tambah User</h1>
            <p class="small text-muted mb-0">Buat akun baru untuk admin/teacher/student.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label class="form-label small">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control form-control-sm @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control form-control-sm @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">Password</label>
                        <input type="password" name="password"
                               class="form-control form-control-sm @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control form-control-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Role</label>
                        <select name="role"
                                class="form-select form-select-sm @error('role') is-invalid @enderror">
                            <option value="student" @selected(old('role')==='student')>Student</option>
                            <option value="teacher" @selected(old('role')==='teacher')>Teacher</option>
                            <option value="admin"   @selected(old('role')==='admin')>Admin</option>
                        </select>
                        @error('role') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
                            Batal
                        </a>
                        <button class="btn btn-primary btn-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
