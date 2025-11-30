<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        
        User::updateOrCreate(
            ['email' => 'rifqialanm@gmail.com'],
            [
                'name' => 'Admin Default',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

      
        User::updateOrCreate(
            ['email' => 'teacher@example.com'],
            [
                'name' => 'Teacher Default',
                'role' => 'teacher',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    
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
