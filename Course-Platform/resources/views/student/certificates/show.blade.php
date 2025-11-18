<x-app-layout :title="'Sertifikat – '.($certificate->course->title ?? 'Course')">
    <div class="container py-4">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">Sertifikat Kelulusan</h1>
                <p class="small text-muted mb-0">
                    Course: <strong>{{ $certificate->course->title ?? '-' }}</strong><br>
                    Nama: <strong>{{ $certificate->user->name ?? auth()->user()->name }}</strong>
                </p>
            </div>
            <a href="{{ route('student.certificates.index') }}" class="btn btn-light btn-sm">
                Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                {{-- di sini nanti bisa kamu ganti dengan template PDF / tampilan lebih mewah --}}
                <p class="mb-0">
                    Sertifikat ini menyatakan bahwa
                    <strong>{{ $certificate->user->name ?? auth()->user()->name }}</strong>
                    telah menyelesaikan course
                    <strong>{{ $certificate->course->title ?? '-' }}</strong>
                    pada tanggal
                    <strong>{{ $certificate->created_at->format('d F Y') }}</strong>.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
