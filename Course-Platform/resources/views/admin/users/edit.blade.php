<x-app-layout :title="'Edit User – '.$user->name">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Edit User</h1>
            <p class="small text-muted mb-0">
                Perbarui data akun user. Biarkan password kosong jika tidak ingin mengubahnya.
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success small mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.users.update',$user) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label class="form-label small">Nama</label>
                        <input type="text" name="name" value="{{ old('name',$user->name) }}"
                               class="form-control form-control-sm @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email" value="{{ old('email',$user->email) }}"
                               class="form-control form-control-sm @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">Password Baru</label>
                        <input type="password" name="password"
                               class="form-control form-control-sm @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        <div class="form-text small">Kosongkan jika tidak ingin mengubah password.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation"
                               class="form-control form-control-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Role</label>
                        <select name="role"
                                class="form-select form-select-sm @error('role') is-invalid @enderror">
                            <option value="admin"   @selected(old('role',$user->role)==='admin')>Admin</option>
                            <option value="teacher" @selected(old('role',$user->role)==='teacher')>Teacher</option>
                            <option value="student" @selected(old('role',$user->role)==='student')>Student</option>
                        </select>
                        @error('role') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check small">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                   value="1" {{ old('is_active',$user->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Akun aktif
                            </label>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
                            Kembali
                        </a>
                        <button class="btn btn-primary btn-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
