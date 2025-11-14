<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','description','start_date','end_date',
        'teacher_id','category_id','status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class)->orderBy('order');
    }

    public function students()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->where('role', User::ROLE_STUDENT);
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }
}
