<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonUserProgress;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function markDone(Lesson $lesson)
    {
        $user = auth()->user();
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

        // 2. Ambil course terkait
        $course = $lesson->module->course;

        // 3. Ambil semua lesson id dalam course tsb
        $lessonIds = $course->modules()
            ->with('lessons:id,module_id')
            ->get()
            ->pluck('lessons.*.id')
            ->flatten()
            ->filter()
            ->values();

        $totalLessons = $lessonIds->count();

        if ($totalLessons > 0) {
            // 4. Hitung berapa lesson yang sudah selesai oleh user ini
            $doneLessons = LessonUserProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $lessonIds)
                ->where('is_done', true)
                ->count();

            // 5. Kalau semua sudah selesai
            if ($doneLessons === $totalLessons) {
                // update pivot enrolledCourses → is_completed = true
                $user->enrolledCourses()
                    ->updateExistingPivot($course->id, ['is_completed' => true]);

                // 6. Cek apakah sertifikat sudah ada
                $alreadyHasCertificate = Certificate::where('course_id', $course->id)
                    ->where('student_id', $user->id)
                    ->exists();

                if (! $alreadyHasCertificate) {
                    // 7. Generate certificate_code unik
                    $code = 'CRS-' . $course->id . '-STU-' . $user->id . '-' . strtoupper(Str::random(6));

                    Certificate::create([
                        'course_id'        => $course->id,
                        'student_id'       => $user->id,
                        'certificate_code' => $code,
                        'issued_at'        => now(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Lesson ditandai selesai.');
    }
}
