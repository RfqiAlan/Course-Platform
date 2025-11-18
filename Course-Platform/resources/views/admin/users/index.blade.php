<x-app-layout title="Manajemen User – Admin">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h5 mb-1">Manajemen User</h1>
                <p class="small text-muted mb-0">Kelola akun admin, teacher, dan student.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah User
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form method="GET" class="row g-2 align-items-center mb-3 small">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control border-start-0"
                                   placeholder="Cari nama atau email">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-select form-select-sm">
                            <option value="">Semua role</option>
                            <option value="admin"   @selected(request('role')==='admin')>Admin</option>
                            <option value="teacher" @selected(request('role')==='teacher')>Teacher</option>
                            <option value="student" @selected(request('role')==='student')>Student</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua status</option>
                            <option value="active"   @selected(request('status')==='active')>Aktif</option>
                            <option value="inactive" @selected(request('status')==='inactive')>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-md-end">
                        <button class="btn btn-outline-primary btn-sm w-100">
                            Terapkan
                        </button>
                    </div>
                </form>

                @if(session('success'))
                    <div class="alert alert-success small">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + ($users->firstItem() - 1) }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-capitalize">
                                    <span class="badge text-bg-light border">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge text-bg-success-subtle text-success">Aktif</span>
                                    @else
                                        <span class="badge text-bg-secondary-subtle text-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.users.edit',$user) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy',$user) }}"
                                              method="POST" class="d-inline"
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
                                <td colspan="6" class="text-center text-muted py-3">
                                    Belum ada data user.
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
