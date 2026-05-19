<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonUserProgress;
use App\Models\Certificate;
use Illuminate\Support\Str;

class LessonController extends Controller
{

    public function markDone(Lesson $lesson)
    {
        $user = auth()->user();

        // Hanya boleh diakses user login & role student
        if (! $user || $user->role !== 'student') {
            abort(403);
        }

        
        $course = $lesson->module->course->load('modules.lessons');

        
        $isEnrolled = $user->enrolledCourses()
            ->where('course_id', $course->id)
            ->exists();

        if (! $isEnrolled) {
            abort(403); 
        }

        // 1. Simpan progress lesson sebagai selesai
        LessonUserProgress::updateOrCreate(
            [
                'lesson_id' => $lesson->id,
                'user_id'   => $user->id,
            ],
            [
                'is_done'      => true,
                'completed_at' => now(),
            ]
        );

        $lessonIds = $course->modules
            ->flatMap(fn ($m) => $m->lessons)
            ->pluck('id')
            ->values();

        $totalLessons = $lessonIds->count();

        if ($totalLessons > 0) {
            
            $doneLessons = LessonUserProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $lessonIds)
                ->where('is_done', true)
                ->count();

            // Jika semua lesson di course sudah selesai
            if ($doneLessons === $totalLessons) {
                
                $user->enrolledCourses()
                    ->updateExistingPivot($course->id, ['is_completed' => true]);

                // apakah sertifikat sudah ada
                $alreadyHasCertificate = Certificate::where('course_id', $course->id)
                    ->where('student_id', $user->id)
                    ->exists();

                // Jika belum ada → buat sertifikat baru
                if (! $alreadyHasCertificate) {
                    $code = 'CRS-' . $course->id
                        . '-STU-' . $user->id
                        . '-' . strtoupper(Str::random(6));

                    Certificate::create([
                        'course_id'        => $course->id,
                        'student_id'       => $user->id,
                        'certificate_code' => $code,
                        'issued_at'        => now(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Materi ditandai selesai. Kamu bisa lanjut ke materi berikutnya.');
    }
}
