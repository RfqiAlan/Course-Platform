<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id','title','body','order','teacher_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function studentsDone()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['is_done','completed_at'])
            ->wherePivot('is_done', true);
    }
}
