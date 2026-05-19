<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    protected $fillable = [
        'thread_id',
        'sender_id',
        'message',
        'read_at',
    ];

    public function thread()
    {
        return $this->belongsTo(PrivateThread::class, 'thread_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
