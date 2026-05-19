<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'summary',
        'order',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class)->orderBy('order');
    }

    public function progresses()
    {
        return $this->hasMany(LessonUserProgress::class);
    }
}
