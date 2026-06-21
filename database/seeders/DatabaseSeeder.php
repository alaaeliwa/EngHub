<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $course1 = Course::create([
            'title' => 'React Frontend Development',
            'code' => 'CS301',
            'description' => 'Learn React from scratch.',
            'instructor' => 'Dr. Smith'
        ]);

        $course2 = Course::create([
            'title' => 'Calculus II',
            'code' => 'MATH202',
            'description' => 'Advanced Integration techniques.',
            'instructor' => 'Dr. Adams'
        ]);

        Material::create([
            'title' => 'React Hooks Guide',
            'type' => 'PDF',
            'file_path' => '#',
            'course_id' => $course1->id,
            'user_id' => $user->id,
        ]);

        Material::create([
            'title' => 'Integration Cheat Sheet',
            'type' => 'PDF',
            'file_path' => '#',
            'course_id' => $course2->id,
            'user_id' => $user->id,
        ]);
    }
}
