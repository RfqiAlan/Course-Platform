<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Certificate;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

        // Course yang dia ajar
        $coursesQuery = Course::where('teacher_id', $teacher->id);

        $totalCourses = (clone $coursesQuery)->count();

        // Modul & lesson dari course yang dia ajar
        $courseIds = (clone $coursesQuery)->pluck('id');

        $totalModules = Module::whereIn('course_id', $courseIds)->count();
        $totalLessons = Lesson::whereIn('module_id', function ($q) use ($courseIds) {
            $q->select('id')->from('modules')->whereIn('course_id', $courseIds);
        })->count();

        // Enrollments & siswa unik
        $totalEnrollments = DB::table('course_student')
            ->whereIn('course_id', $courseIds)
            ->count();

        $totalStudents = DB::table('course_student')
            ->whereIn('course_id', $courseIds)
            ->distinct('student_id')
            ->count('student_id');

        $avgModulesPerCourse   = $totalCourses > 0 ? round($totalModules / $totalCourses, 1) : 0;
        $avgStudentsPerCourse  = $totalCourses > 0 ? round($totalStudents / $totalCourses, 1) : 0;

        // Sertifikat terbit untuk course yang dia ajar
        $totalCertificates = Certificate::whereIn('course_id', $courseIds)->count();

        // Course terbaru
        $recentCourses = (clone $coursesQuery)
            ->with(['category', 'students'])
            ->withCount('students')
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', [
            'totalCourses'      => $totalCourses,
            'totalModules'      => $totalModules,
            'totalLessons'      => $totalLessons,
            'totalEnrollments'  => $totalEnrollments,
            'totalStudents'     => $totalStudents,
            'totalCertificates' => $totalCertificates,
            'avgModulesPerCourse'  => $avgModulesPerCourse,
            'avgStudentsPerCourse' => $avgStudentsPerCourse,
            'recentCourses'        => $recentCourses,
        ]);
    }
}
