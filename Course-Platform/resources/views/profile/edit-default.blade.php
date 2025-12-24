<x-app-layout title="Pengaturan Profil">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="mb-4">
                    <h4 class="fw-bold mb-1">Pengaturan Profil</h4>
                    <p class="text-muted small mb-0">Kelola informasi akun dan keamanan Anda</p>
                </div>

                <div class="row g-4">
                    <!-- Sidebar Profile Card -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body text-center p-4">
                                <!-- Avatar -->
                                <div class="position-relative d-inline-block mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                         style="width: 100px; height: 100px; background: linear-gradient(135deg, #0F3D73 0%, #3b82f6 100%); font-size: 2.5rem; color: #fff; font-weight: 600;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-3 border-white" style="width: 20px; height: 20px;"></span>
                                </div>

                                <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                                <p class="text-muted small mb-2">{{ auth()->user()->email }}</p>

                                <!-- Role Badge -->
                                @php
                                    $role = auth()->user()->role;
                                    $roleColors = [
                                        'admin' => 'bg-danger-subtle text-danger',
                                        'teacher' => 'bg-primary-subtle text-primary',
                                        'student' => 'bg-success-subtle text-success',
                                    ];
                                    $roleLabels = [
                                        'admin' => 'Administrator',
                                        'teacher' => 'Pengajar',
                                        'student' => 'Siswa',
                                    ];
                                @endphp
                                <span class="badge {{ $roleColors[$role] ?? 'bg-secondary-subtle text-secondary' }} rounded-pill px-3 py-2">
                                    <i class="bi bi-shield-check me-1"></i>{{ $roleLabels[$role] ?? ucfirst($role) }}
                                </span>

                                <hr class="my-3">

                                <!-- Quick Info -->
                                <div class="text-start">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-calendar3 text-muted me-2"></i>
                                        <small class="text-muted">Bergabung {{ auth()->user()->created_at->translatedFormat('d F Y') }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <small class="text-muted">Akun {{ auth()->user()->is_active ? 'Aktif' : 'Nonaktif' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="card border-0 shadow-sm rounded-4 mt-3">
                            <div class="card-body p-2">
                                <nav class="nav flex-column nav-pills">
                                    <a class="nav-link active rounded-3 mb-1" href="#profile-info" data-bs-toggle="pill">
                                        <i class="bi bi-person me-2"></i>Informasi Profil
                                    </a>
                                    <a class="nav-link rounded-3 mb-1" href="#password" data-bs-toggle="pill">
                                        <i class="bi bi-key me-2"></i>Ubah Password
                                    </a>
                                    <a class="nav-link rounded-3 text-danger" href="#delete-account" data-bs-toggle="pill">
                                        <i class="bi bi-trash me-2"></i>Hapus Akun
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-md-8">
                        <div class="tab-content">
                            <!-- Profile Information -->
                            <div class="tab-pane fade show active" id="profile-info">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                                        <h5 class="fw-semibold mb-1">
                                            <i class="bi bi-person-circle text-primary me-2"></i>Informasi Profil
                                        </h5>
                                        <p class="text-muted small mb-0">Perbarui informasi profil dan alamat email Anda</p>
                                    </div>
                                    <div class="card-body p-4">
                                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                            @csrf
                                        </form>

                                        <form method="post" action="{{ route('profile.update') }}">
                                            @csrf
                                            @method('patch')

                                            <div class="mb-3">
                                                <label for="name" class="form-label small fw-semibold">Nama Lengkap</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="bi bi-person text-muted"></i>
                                                    </span>
                                                    <input type="text" id="name" name="name"
                                                           class="form-control border-start-0 @error('name') is-invalid @enderror"
                                                           value="{{ old('name', $user->name) }}" required>
                                                </div>
                                                @error('name')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="email" class="form-label small fw-semibold">Alamat Email</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="bi bi-envelope text-muted"></i>
                                                    </span>
                                                    <input type="email" id="email" name="email"
                                                           class="form-control border-start-0 @error('email') is-invalid @enderror"
                                                           value="{{ old('email', $user->email) }}" required>
                                                </div>
                                                @error('email')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror

                                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                                    <div class="mt-2">
                                                        <p class="text-warning small mb-1">
                                                            <i class="bi bi-exclamation-triangle me-1"></i>Email Anda belum diverifikasi.
                                                        </p>
                                                        <button form="send-verification" class="btn btn-link btn-sm p-0 text-primary">
                                                            Kirim ulang email verifikasi
                                                        </button>

                                                        @if (session('status') === 'verification-link-sent')
                                                            <p class="text-success small mt-1">
                                                                <i class="bi bi-check-circle me-1"></i>Link verifikasi baru telah dikirim.
                                                            </p>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="d-flex align-items-center gap-3">
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                                                </button>

                                                @if (session('status') === 'profile-updated')
                                                    <span class="text-success small">
                                                        <i class="bi bi-check-circle me-1"></i>Tersimpan!
                                                    </span>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Update Password -->
                            <div class="tab-pane fade" id="password">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                                        <h5 class="fw-semibold mb-1">
                                            <i class="bi bi-shield-lock text-primary me-2"></i>Ubah Password
                                        </h5>
                                        <p class="text-muted small mb-0">Pastikan akun Anda menggunakan password yang kuat</p>
                                    </div>
                                    <div class="card-body p-4">
                                        <form method="post" action="{{ route('password.update') }}">
                                            @csrf
                                            @method('put')

                                            <div class="mb-3">
                                                <label for="current_password" class="form-label small fw-semibold">Password Saat Ini</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="bi bi-lock text-muted"></i>
                                                    </span>
                                                    <input type="password" id="current_password" name="current_password"
                                                           class="form-control border-start-0 @error('current_password', 'updatePassword') is-invalid @enderror"
                                                           autocomplete="current-password">
                                                </div>
                                                @error('current_password', 'updatePassword')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label small fw-semibold">Password Baru</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="bi bi-key text-muted"></i>
                                                    </span>
                                                    <input type="password" id="password" name="password"
                                                           class="form-control border-start-0 @error('password', 'updatePassword') is-invalid @enderror"
                                                           autocomplete="new-password">
                                                </div>
                                                @error('password', 'updatePassword')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="password_confirmation" class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="bi bi-key-fill text-muted"></i>
                                                    </span>
                                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                                           class="form-control border-start-0"
                                                           autocomplete="new-password">
                                                </div>
                                                @error('password_confirmation', 'updatePassword')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="d-flex align-items-center gap-3">
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="bi bi-check-lg me-1"></i>Perbarui Password
                                                </button>

                                                @if (session('status') === 'password-updated')
                                                    <span class="text-success small">
                                                        <i class="bi bi-check-circle me-1"></i>Password diperbarui!
                                                    </span>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Account -->
                            <div class="tab-pane fade" id="delete-account">
                                <div class="card border-0 shadow-sm rounded-4 border-danger">
                                    <div class="card-header bg-danger-subtle border-0 pt-4 pb-0 px-4">
                                        <h5 class="fw-semibold mb-1 text-danger">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Hapus Akun
                                        </h5>
                                        <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan</p>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="alert alert-warning border-0 mb-4">
                                            <div class="d-flex">
                                                <i class="bi bi-exclamation-triangle-fill text-warning me-3 fs-4"></i>
                                                <div>
                                                    <h6 class="alert-heading mb-1">Perhatian!</h6>
                                                    <p class="mb-0 small">Setelah akun Anda dihapus, semua data dan informasi akan hilang secara permanen. Sebelum menghapus, pastikan Anda sudah mengunduh data yang ingin disimpan.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                            <i class="bi bi-trash me-1"></i>Hapus Akun Saya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus Akun
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p class="text-muted">Apakah Anda yakin ingin menghapus akun? Semua data akan hilang secara permanen.</p>

                        <div class="mb-3">
                            <label for="delete_password" class="form-label small fw-semibold">Masukkan Password untuk Konfirmasi</label>
                            <input type="password" id="delete_password" name="password"
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                   placeholder="Password Anda">
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Ya, Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .nav-pills .nav-link {
            color: #64748b;
            font-size: 0.875rem;
            padding: 0.6rem 1rem;
            transition: all 0.2s ease;
        }
        .nav-pills .nav-link:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }
        .nav-pills .nav-link.active {
            background-color: #0F3D73;
            color: #fff !important;
        }
        .nav-pills .nav-link.text-danger:hover {
            background-color: #fef2f2;
            color: #dc3545;
        }
        .nav-pills .nav-link.text-danger.active {
            background-color: #dc3545;
            color: #fff !important;
        }
        .form-control:focus {
            border-color: #0F3D73;
            box-shadow: 0 0 0 0.2rem rgba(15, 61, 115, 0.15);
        }
        .input-group-text {
            border-color: #dee2e6;
        }
        .input-group .form-control {
            border-color: #dee2e6;
            background-color: #fff;
            color: #1e293b;
        }
        .form-label {
            color: #1e293b;
        }
        .card-header h5 {
            color: #1e293b;
        }
        .card-header p {
            color: #64748b !important;
        }
        .card {
            background-color: #fff;
        }
        .tab-pane .card-body {
            background-color: #fff;
        }
    </style>
    @endpush

    @if($errors->userDeletion->isNotEmpty())
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
            deleteModal.show();
        });
    </script>
    @endpush
    @endif
</x-app-layout>
