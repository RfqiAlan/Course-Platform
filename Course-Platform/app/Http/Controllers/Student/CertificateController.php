<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;

class CertificateController extends Controller
{
    public function show(Course $course)
    {
        $user = auth()->user();

        $certificate = Certificate::where('course_id', $course->id)
            ->where('student_id', $user->id)
            ->firstOrFail();

        return view('student.courses.certificate', compact('course', 'certificate'));
    }
}
