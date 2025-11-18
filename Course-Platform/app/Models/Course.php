<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'category_id',
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'preview_video',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'student_id')
            ->withPivot(['enrolled_at', 'is_completed'])
            ->withTimestamps();
    }
    public function getNextLesson($lesson)
    {
    $all = $this->modules->flatMap->lessons->sortBy('order')->values();
    $index = $all->search(fn($l) => $l->id == $lesson->id);
    return $all[$index + 1] ?? null;
    }

public function getPrevLesson($lesson)
    {
    $all = $this->modules->flatMap->lessons->sortBy('order')->values();
    $index = $all->search(fn($l) => $l->id == $lesson->id);
    return $all[$index - 1] ?? null;
    }
public function certificates()
    {
    return $this->hasMany(\App\Models\Certificate::class);
    }


}
