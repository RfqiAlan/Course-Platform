<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateThread extends Model
{
    protected $fillable = [
        'course_id',
        'teacher_id',
        'student_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function messages()
    {
        return $this->hasMany(PrivateMessage::class, 'thread_id');
    }
}
