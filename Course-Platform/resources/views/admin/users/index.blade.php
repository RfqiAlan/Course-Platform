<x-app-layout title="Manajemen User – Admin">
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h5 mb-1">Manajemen User</h1>
                <p class="text-muted small mb-0">Kelola akun admin, teacher, dan student.</p>
            </div>

            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah User
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">

                <form method="GET" class="row g-3 align-items-end mb-4 small">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Cari User</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control border-start-0"
                                   placeholder="Cari nama atau email...">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" class="form-select form-select-sm">
                            <option value="">Semua role</option>
                            <option value="admin"   @selected(request('role')==='admin')>Admin</option>
                            <option value="teacher" @selected(request('role')==='teacher')>Teacher</option>
                            <option value="student" @selected(request('role')==='student')>Student</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua status</option>
                            <option value="active"   @selected(request('status')==='active')>Aktif</option>
                            <option value="inactive" @selected(request('status')==='inactive')>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-primary btn-sm w-100">
                            Terapkan
                        </button>
                    </div>

                </form>
                @if(session('success'))
                    <div class="alert alert-success border-0 small d-flex align-items-center mb-3">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th class="text-end" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="small">
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration + ($users->firstItem() - 1) }}</td>

                                    <td class="fw-semibold">
                                        {{ $user->name }}
                                    </td>

                                    <td class="text-muted">
                                        {{ $user->email }}
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark border text-capitalize">
                                            {{ $user->role }}
                                        </span>
                                    </td>

                                    <td>
                                        @if($user->is_active)
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end">

                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin hapus user ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                                        <strong class="d-block mb-1">Belum ada user</strong>
                                        <p class="small mb-3">Tambahkan user baru untuk memulai pengelolaan akun.</p>
                                        <a href="{{ route('admin.users.create') }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle me-1"></i> Tambah User
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
