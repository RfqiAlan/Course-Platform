<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ======================
        // ADMIN DEFAULT
        // ======================
        User::updateOrCreate(
            ['email' => 'rifqialanm@gmail.com'],
            [
                'name' => 'Admin Default',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // ======================
        // TEACHER DEFAULT
        // ======================
        User::updateOrCreate(
            ['email' => 'teacher@example.com'],
            [
                'name' => 'Teacher Default',
                'role' => 'teacher',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        // ======================
        // STUDENT DEFAULT
        // ======================
        User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student Default',
                'role' => 'student',
                'password' => Hash::make('password'),
            ]
        );
    }
}
