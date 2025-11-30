<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
  
    public function index()
    {
        $user = auth()->user();

        $certificates = Certificate::with('course')
            ->where('student_id', $user->id)
            ->latest()
            ->get();

        return view('student.certificates.index', compact('certificates'));
    }

  
    public function show(Certificate $certificate)
    {
        $user = auth()->user();

        // pastikan hanya pemilik yang boleh lihat
        abort_unless($certificate->student_id === $user->id, 403);

        // view yang kamu kirim sebelumnya: student/certificates/show.blade.php
        return view('student.certificates.show', [
            'certificate' => $certificate,
        ]);
    }

    /**
     * OPSIONAL: Tampilkan sertifikat berdasarkan course,
     * misal: /student/courses/{course}/certificate
     * Route (contoh):
     * GET /student/courses/{course}/certificate -> student.courses.certificate.show
     */
    public function showByCourse(Course $course)
    {
        $user = auth()->user();

        $certificate = Certificate::where('course_id', $course->id)
            ->where('student_id', $user->id)
            ->firstOrFail();

        // kalau kamu punya view khusus per course:
        // return view('student.courses.certificate', compact('course', 'certificate'));

        // atau pakai view yang sama dengan show():
        return view('student.certificates.show', [
            'certificate' => $certificate,
        ]);
    }

    /**
     * Download sertifikat sebagai PDF menggunakan template Canva.
     * Route (contoh):
     * GET /student/certificates/{certificate}/download -> student.certificates.download
     */
    public function download(Certificate $certificate)
    {
        $user = auth()->user();

        // pastikan hanya pemilik yang bisa download
        abort_unless($certificate->student_id === $user->id, 403);

        $course = $certificate->course;

        $pdf = Pdf::loadView('certificates.template', [
            'user'   => $user,
            'course' => $course,
            'date'   => $certificate->issued_at
                ? $certificate->issued_at->format('d F Y')
                : now()->format('d F Y'),
            'code'   => $certificate->certificate_code,
        ]);

        $fileName = 'sertifikat_'.$user->id.'_'.$course->id.'.pdf';

        return $pdf->download($fileName);
    }
}
