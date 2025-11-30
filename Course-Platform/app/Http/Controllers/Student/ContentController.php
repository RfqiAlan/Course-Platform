<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
   
    public function download(Content $content)
    {
        $user = auth()->user();

       

        if (!$content->file_path || !Storage::disk('public')->exists($content->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($content->file_path);
    }


    public function stream(Content $content)
    {
        $user = auth()->user();

      

        if (!$content->video_path || !Storage::disk('public')->exists($content->video_path)) {
            abort(404, 'Video tidak ditemukan.');
        }

        $path = Storage::disk('public')->path($content->video_path);

        return response()->file($path, [
            'Content-Type' => 'video/mp4',
        ]);
    }


    public function image(Content $content)
    {
        $user = auth()->user();

        if (!$content->file_path || !Storage::disk('public')->exists($content->file_path)) {
            abort(404, 'Gambar tidak ditemukan.');
        }

        $path = Storage::disk('public')->path($content->file_path);

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
        ]);
    }
}
