<?php

namespace App\Policies;

use App\Models\ChatThread;
use App\Models\User;
use Illuminate\Auth\Access\Response;

// app/Policies/ChatThreadPolicy.php
class ChatThreadPolicy
{
    public function view(User $user, ChatThread $thread)
    {
        return $user->id === $thread->student_id
            || $user->id === $thread->teacher_id;
    }

    public function sendMessage(User $user, ChatThread $thread)
    {
        return $this->view($user, $thread);
    }
}
