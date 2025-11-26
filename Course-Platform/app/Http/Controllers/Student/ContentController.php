<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Download file materi (PDF/DOC/PPT/ZIP/RAR/dll).
     * Route: student.contents.download
     * URL  : /student/contents/{content}/download
     */
    public function download(Content $content)
    {
        $user = auth()->user();

        // OPTIONAL: cek apakah student sudah enroll di course terkait
        // $course = $content->lesson->module->course;
        // if (!$course->students()->where('user_id', $user->id)->exists()) {
        //     abort(403);
        // }

        if (!$content->file_path || !Storage::disk('public')->exists($content->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($content->file_path);
    }

    /**
     * Stream video materi ke video tag.
     * Route: student.contents.stream
     * URL  : /student/contents/{content}/stream
     */
    public function stream(Content $content)
    {
        $user = auth()->user();

        // OPTIONAL: cek enroll

        if (!$content->video_path || !Storage::disk('public')->exists($content->video_path)) {
            abort(404, 'Video tidak ditemukan.');
        }

        $path = Storage::disk('public')->path($content->video_path);

        return response()->file($path, [
            'Content-Type' => 'video/mp4',
        ]);
    }

    /**
     * Tampilkan gambar (file type image) secara inline.
     * Route: student.contents.image
     * URL  : /student/contents/{content}/image
     */
    public function image(Content $content)
    {
        $user = auth()->user();

        // OPTIONAL: cek enroll

        if (!$content->file_path || !Storage::disk('public')->exists($content->file_path)) {
            abort(404, 'Gambar tidak ditemukan.');
        }

        $path = Storage::disk('public')->path($content->file_path);

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
        ]);
    }
}
