<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckCourseActive
{
    public function handle(Request $request, Closure $next)
    {
        $course = $request->route('course');

        if (!$course) {
            return $next($request);
        }

        if (!$course->is_active) {
            return back()->with('error', 'Kursus ini sedang tidak aktif.');
        }

        $today = Carbon::today();

        if ($course->start_date && $today->lt(Carbon::parse($course->start_date))) {
            return back()->with('error', 'Kursus belum dibuka.');
        }

        if ($course->end_date && $today->gt(Carbon::parse($course->end_date))) {
            return back()->with('error', 'Kursus sudah ditutup.');
        }

        return $next($request);
    }
}
