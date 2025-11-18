<x-app-layout :title="'Sertifikat – '.$course->title">
    <div class="container py-5 d-flex justify-content-center">
        <div class="border border-3 p-5 text-center" style="max-width: 800px; border-radius: 16px;">
            <h1 class="mb-3" style="font-size: 32px; font-weight:700;">CERTIFICATE OF COMPLETION</h1>

            <p class="mb-1">This is to certify that</p>
            <h2 class="mb-3" style="font-size: 28px; font-weight:700;">
                {{ auth()->user()->name }}
            </h2>

            <p class="mb-1">has successfully completed the course</p>
            <h3 class="mb-3" style="font-size: 24px;">
                {{ $course->title }}
            </h3>

            <p class="mb-1">Issued on: {{ $certificate->issued_at->format('d F Y') }}</p>
            <p class="mb-4">Certificate Code: <strong>{{ $certificate->certificate_code }}</strong></p>

            <div class="mt-5 d-flex justify-content-between">
                <div>
                    <hr style="width:200px; margin:0 auto 4px;">
                    <small>Instructor</small>
                </div>
                <div>
                    <hr style="width:200px; margin:0 auto 4px;">
                    <small>Program Director</small>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
