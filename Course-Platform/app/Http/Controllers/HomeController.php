<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 5 course terpopuler berdasarkan jumlah peserta
        $popularCourses = Course::active()
            ->withCount('students')
            ->orderByDesc('students_count')
            ->take(5)
            ->get();

        return view('home', compact('popularCourses'));
    }

    public function dashboard()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return view('dashboard.admin');
        } elseif ($user->isTeacher()) {
            return view('dashboard.teacher');
        }

        return view('dashboard.student');
    }
}
