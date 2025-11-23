<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index()
{
    return view('admin.dashboard', [
        'totalUsers'        => \App\Models\User::count(),
        'totalAdmins'       => \App\Models\User::where('role', 'admin')->count(),
        'totalTeachers'     => \App\Models\User::where('role', 'teacher')->count(),
        'totalStudents'     => \App\Models\User::where('role', 'student')->count(),
        'totalCourses'      => \App\Models\Course::count(),
        'totalCategories'   => \App\Models\Category::count(),
        'totalEnrollments'  => \DB::table('course_student')->count(),
        'totalCertificates' => \App\Models\Certificate::count(),
        'recentCourses'     => \App\Models\Course::with(['category','teacher','students'])
                                ->withCount('students')
                                ->latest()->take(5)->get(),
        'recentUsers'       => \App\Models\User::latest()->take(5)->get(),
    ]);
}

}
