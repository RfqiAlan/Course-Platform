<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // kalau pakai

class User extends Authenticatable 
{
    use HasFactory, Notifiable; // HasApiTokens kalau perlu

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
    ];

    // === Helper role ===
    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isTeacher(): bool { return $this->role === 'teacher'; }
    public function isStudent(): bool { return $this->role === 'student'; }

    // === Relasi ===
    // course yang dia ajar
    public function taughtCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    // course yang dia ikuti (sebagai student)
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
            ->withPivot(['enrolled_at', 'is_completed'])
            ->withTimestamps();
    }
    public function certificates()
    {
    return $this->hasMany(\App\Models\Certificate::class, 'student_id');
    }

}
