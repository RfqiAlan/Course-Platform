<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'type',
        'title',
        'body',
        'file_path',
        'video_path',
        'order',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
