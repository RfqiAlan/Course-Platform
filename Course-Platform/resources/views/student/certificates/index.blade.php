<x-app-layout :title="'Sertifikat Saya'">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Sertifikat Saya</h1>
            <p class="small text-muted mb-0">
                Semua sertifikat course yang sudah kamu selesaikan.
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                @if($certificates->isEmpty())
                    <p class="text-muted small mb-0">
                        Belum ada sertifikat yang diterbitkan untuk akun ini.
                    </p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light small">
                            <tr>
                                <th>Course</th>
                                <th>Tanggal Terbit</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="small">
                            @foreach($certificates as $certificate)
                                <tr>
                                    <td>{{ $certificate->course->title ?? '-' }}</td>
                                    <td>{{ $certificate->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('student.certificates.show', $certificate) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            Lihat / Download
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
