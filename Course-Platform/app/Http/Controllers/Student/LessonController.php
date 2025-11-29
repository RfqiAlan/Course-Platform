<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonUserProgress;
use App\Models\Certificate;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    /**
     * Student menandai 1 lesson sebagai selesai.
     * - Simpan progress di lesson_user_progress
     * - Jika semua lesson di course sudah selesai:
     *   - set is_completed di pivot enrolledCourses
     *   - generate sertifikat jika belum ada
     */
    public function markDone(Lesson $lesson)
    {
        $user = auth()->user();

        // Hanya boleh diakses user login & role student
        if (! $user || $user->role !== 'student') {
            abort(403);
        }

        // Ambil course lewat relasi module → course
        $course = $lesson->module->course->load('modules.lessons');

        // Pastikan student sudah enroll di course ini
        $isEnrolled = $user->enrolledCourses()
            ->where('course_id', $course->id)
            ->exists();

        if (! $isEnrolled) {
            abort(403); // tidak boleh mark done kalau belum ikut course
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

        // 2. Kumpulkan semua lesson id dalam course ini
        $lessonIds = $course->modules
            ->flatMap(fn ($m) => $m->lessons)
            ->pluck('id')
            ->values();

        $totalLessons = $lessonIds->count();

        if ($totalLessons > 0) {
            // 3. Hitung berapa lesson yang sudah selesai oleh student ini
            $doneLessons = LessonUserProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $lessonIds)
                ->where('is_done', true)
                ->count();

            // 4. Jika semua lesson di course sudah selesai
            if ($doneLessons === $totalLessons) {
                // set is_completed di pivot enrolledCourses
                $user->enrolledCourses()
                    ->updateExistingPivot($course->id, ['is_completed' => true]);

                // 5. Cek apakah sertifikat sudah ada
                $alreadyHasCertificate = Certificate::where('course_id', $course->id)
                    ->where('student_id', $user->id)
                    ->exists();

                // 6. Jika belum ada → buat sertifikat baru
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
