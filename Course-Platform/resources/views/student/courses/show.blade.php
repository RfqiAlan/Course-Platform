@php
    $certificate = \App\Models\Certificate::where('course_id', $course->id)
        ->where('student_id', auth()->id())
        ->first();
@endphp

@if($certificate)
    <a href="{{ route('student.courses.certificate.show', $course) }}"
       class="btn btn-success btn-sm">
        Lihat Sertifikat
    </a>
@endif
