<x-app-layout :title="'Sertifikat – '.($certificate->course->title ?? 'Course')">
    <div class="container py-4">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">Sertifikat Kelulusan</h1>
                <p class="small text-muted mb-0">
                    Course: <strong>{{ $certificate->course->title ?? '-' }}</strong><br>
                    Nama: <strong>{{ $certificate->student->name ?? auth()->user()->name }}</strong>
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('student.certificates.download', $certificate) }}" class="btn btn-primary btn-sm">
                    Download Sertifikat PDF
                </a>
                <a href="{{ route('student.certificates.index') }}" class="btn btn-light btn-sm">
                    Kembali
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <p class="mb-0">
                    Sertifikat ini menyatakan bahwa
                    <strong>{{ $certificate->student->name ?? auth()->user()->name }}</strong>
                    telah menyelesaikan course
                    <strong>{{ $certificate->course->title ?? '-' }}</strong>
                    pada tanggal
                    <strong>{{ $certificate->issued_at
                        ? $certificate->issued_at->format('d F Y')
                        : $certificate->created_at->format('d F Y') }}</strong>.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
