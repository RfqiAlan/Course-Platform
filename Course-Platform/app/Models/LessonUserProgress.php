<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonUserProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'user_id',
        'is_done',
        'quiz_passed',
        'completed_at',
    ];

    protected $casts = [
        'is_done'     => 'boolean',
        'quiz_passed' => 'boolean',
        'completed_at'=> 'datetime',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
