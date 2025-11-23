<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    // LIST semua sertifikat milik student yang login
    public function index(Request $request)
    {
        $user = $request->user();

        $certificates = Certificate::with('course')
            ->where('student_id', $user->id)
            ->latest()
            ->get();

        return view('student.certificates.index', [
            'certificates' => $certificates,
        ]);
    }

    // DETAIL satu sertifikat (misal tampilan HTML / download PDF)
    public function show(Certificate $certificate)
    {
        // pastikan student hanya bisa lihat sertifikat miliknya
        abort_unless($certificate->student_id === auth()->id(), 403);

        return view('student.certificates.show', [
            'certificate' => $certificate,
        ]);
    }

    // OPSIONAL: sertifikat berdasarkan course
    public function showByCourse(Course $course)
    {
        $userId = auth()->id();

        $certificate = Certificate::where('course_id', $course->id)
            ->where('user_id', $userId)
            ->firstOrFail();

        return view('student.certificates.show', [
            'certificate' => $certificate,
        ]);
    }
}
