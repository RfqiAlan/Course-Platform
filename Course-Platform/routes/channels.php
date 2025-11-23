<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Course;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * Channel private chat per course.
 * Semua user yang login boleh join, nanti bisa kamu ganti cek enrollment.
 */
Broadcast::channel('course.{courseId}', function ($user, $courseId) {
    // contoh lebih aman: hanya yang enrolled
    // return $user->courses()->where('course_id', $courseId)->exists();

    return !is_null($user);
});
