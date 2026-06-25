<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@enghub.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Create Departments
        $compDept = Department::create(['name' => 'Computer Engineering']);
        $elecDept = Department::create(['name' => 'Electrical Engineering']);
        $civilDept = Department::create(['name' => 'Civil Engineering']);

        // 3. Create Users
        $compUser = User::create([
            'first_name' => 'Computer',
            'last_name' => 'Student',
            'email' => 'computer@enghub.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'department_id' => $compDept->id,
        ]);

        $elecUser = User::create([
            'first_name' => 'Electrical',
            'last_name' => 'Student',
            'email' => 'electrical@enghub.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'department_id' => $elecDept->id,
        ]);

        $civilUser = User::create([
            'first_name' => 'Civil',
            'last_name' => 'Student',
            'email' => 'civil@enghub.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'department_id' => $civilDept->id,
        ]);

        // 4. Create Computer Engineering Courses
        $courses = [
            // Level 1 - Sem 1
            ['code' => 'ARAB 1202', 'title' => 'Arabic Language (Grammar & Morphology)', 'year' => 1, 'semester' => 1],
            ['code' => 'ENGG 1101', 'title' => 'Introduction to Engineering', 'year' => 1, 'semester' => 1],
            ['code' => 'ENGG 1104', 'title' => 'Scientific Research Methodology', 'year' => 1, 'semester' => 1],
            ['code' => 'ENGG 1204', 'title' => 'Engineering Drawing', 'year' => 1, 'semester' => 1],
            ['code' => 'MATHA 1301', 'title' => 'Calculus (A)', 'year' => 1, 'semester' => 1],
            ['code' => 'PHYSA 1102', 'title' => 'General Physics Lab (A)', 'year' => 1, 'semester' => 1],
            ['code' => 'PHYSA 1301', 'title' => 'General Physics (A)', 'year' => 1, 'semester' => 1],
            ['code' => 'QURN 1101', 'title' => 'Holy Quran (1)', 'year' => 1, 'semester' => 1],
            ['code' => 'SHAR 1202', 'title' => 'Studies in Jurisprudence', 'year' => 1, 'semester' => 1],

            // Level 1 - Sem 2
            ['code' => 'CHEM 1302', 'title' => 'General Chemistry', 'year' => 1, 'semester' => 2],
            ['code' => 'ENGG 1103', 'title' => 'Workshop Technology', 'year' => 1, 'semester' => 2],
            ['code' => 'ENGG 1203', 'title' => 'Introduction to Computers', 'year' => 1, 'semester' => 2],
            ['code' => 'ENGG 1305', 'title' => 'Technical English Language', 'year' => 1, 'semester' => 2],
            ['code' => 'HADT 1202', 'title' => 'Studies in the Prophet\'s Biography', 'year' => 1, 'semester' => 2],
            ['code' => 'MATHB 1401', 'title' => 'Calculus (B)', 'year' => 1, 'semester' => 2],
            ['code' => 'PHYSB 1301', 'title' => 'General Physics (B)', 'year' => 1, 'semester' => 2],

            // Level 2 - Sem 1
            ['code' => 'ECOM 2401', 'title' => 'Computer Programming (1)', 'year' => 2, 'semester' => 1],
            ['code' => 'ECOM 2411', 'title' => 'Combinational Logic Design', 'year' => 2, 'semester' => 1],
            ['code' => 'EELE 2110', 'title' => 'Electrical Circuits (1) (Lab)', 'year' => 2, 'semester' => 1],
            ['code' => 'EELE 2310', 'title' => 'Electrical Circuits (1)', 'year' => 2, 'semester' => 1],
            ['code' => 'OPTI 3206', 'title' => 'University Elective', 'year' => 2, 'semester' => 1],
            ['code' => 'QURN 2101', 'title' => 'Holy Quran (2)', 'year' => 2, 'semester' => 1],
            ['code' => 'QURN 2201', 'title' => 'Studies in Quran and its Sciences', 'year' => 2, 'semester' => 1],

            // Level 2 - Sem 2
            ['code' => 'ECOM 2402', 'title' => 'Computer Programming (2)', 'year' => 2, 'semester' => 2],
            ['code' => 'ECOM 2421', 'title' => 'Sequential Logic Design', 'year' => 2, 'semester' => 2],
            ['code' => 'EELE 2120', 'title' => 'Electronics (1) Lab', 'year' => 2, 'semester' => 2],
            ['code' => 'EELE 2320', 'title' => 'Electronics (1)', 'year' => 2, 'semester' => 2],
            ['code' => 'MATH 2302', 'title' => 'Ordinary Differential Equations', 'year' => 2, 'semester' => 2],
            ['code' => 'MATH 2341', 'title' => 'Linear Algebra', 'year' => 2, 'semester' => 2],
            ['code' => 'VOLN 1000', 'title' => 'Volunteer Work / 60 hours', 'year' => 2, 'semester' => 2],

            // Level 3 - Sem 1
            ['code' => 'ECOM 3411', 'title' => 'Discrete Mathematics', 'year' => 3, 'semester' => 1],
            ['code' => 'ECOM 3412', 'title' => 'Data Structures and Algorithms', 'year' => 3, 'semester' => 1],
            ['code' => 'EELE 3110', 'title' => 'Signals and Linear Systems (Lab)', 'year' => 3, 'semester' => 1],
            ['code' => 'EELE 3310', 'title' => 'Signals and Linear Systems', 'year' => 3, 'semester' => 1],
            ['code' => 'EELE 3340', 'title' => 'Probability Theory and Statistics', 'year' => 3, 'semester' => 1],
            ['code' => 'QURN 3101', 'title' => 'Holy Quran (3)', 'year' => 3, 'semester' => 1],

            // Level 3 - Sem 2
            ['code' => 'ECOM 3421', 'title' => 'Computer Architecture', 'year' => 3, 'semester' => 2],
            ['code' => 'ECOM 3422', 'title' => 'Database Systems', 'year' => 3, 'semester' => 2],
            ['code' => 'EELE 3121', 'title' => 'Digital Electronics (Lab)', 'year' => 3, 'semester' => 2],
            ['code' => 'EELE 3160', 'title' => 'Linear Control Systems (Lab)', 'year' => 3, 'semester' => 2],
            ['code' => 'EELE 3321', 'title' => 'Digital Electronics', 'year' => 3, 'semester' => 2],
            ['code' => 'EELE 3360', 'title' => 'Linear Control Systems', 'year' => 3, 'semester' => 2],
            ['code' => 'SHAR 2207', 'title' => 'Islamic Systems', 'year' => 3, 'semester' => 2],

            // Level 4 - Sem 1
            ['code' => 'AQID 3306', 'title' => 'Studies in Creed', 'year' => 4, 'semester' => 1],
            ['code' => 'ECOM 4401', 'title' => 'Operating Systems', 'year' => 4, 'semester' => 1],
            ['code' => 'ECOM 4411', 'title' => 'Data Communications', 'year' => 4, 'semester' => 1],
            ['code' => 'ECOM 4412', 'title' => 'Assembly Language', 'year' => 4, 'semester' => 1],
            ['code' => 'QURN 4102', 'title' => 'Holy Quran (4)', 'year' => 4, 'semester' => 1],

            // Level 4 - Sem 2
            ['code' => 'ECOM 4421', 'title' => 'Computer Networks', 'year' => 4, 'semester' => 2],
            ['code' => 'ECOM 4422', 'title' => 'Embedded Systems', 'year' => 4, 'semester' => 2],
            ['code' => 'ECOM 4423', 'title' => 'Hardware Description Languages', 'year' => 4, 'semester' => 2],
            ['code' => 'ECOM 4424', 'title' => 'Software Engineering', 'year' => 4, 'semester' => 2],

            // Level 5 - Sem 1
            ['code' => 'AQID 3201', 'title' => 'Contemporary Islamic World', 'year' => 5, 'semester' => 1],
            ['code' => 'ECOM 5000', 'title' => 'Practical Training (250 hours)', 'year' => 5, 'semester' => 1],
            ['code' => 'ECOM 5301', 'title' => 'Graduation Project (1)', 'year' => 5, 'semester' => 1],
            ['code' => 'OPTI 5401', 'title' => 'Elective Course (1)', 'year' => 5, 'semester' => 1],
            ['code' => 'OPTI 5402', 'title' => 'Elective Course (2)', 'year' => 5, 'semester' => 1],
            ['code' => 'POLS 3220', 'title' => 'Palestinian Studies', 'year' => 5, 'semester' => 1],

            // Level 5 - Sem 2
            ['code' => 'ECOM 5302', 'title' => 'Graduation Project (2)', 'year' => 5, 'semester' => 2],
            ['code' => 'HADT 4204', 'title' => 'Studies in the Noble Hadith', 'year' => 5, 'semester' => 2],
            ['code' => 'OPTI 5403', 'title' => 'Elective Course (3)', 'year' => 5, 'semester' => 2],
            ['code' => 'OPTI 5404', 'title' => 'Elective Course (4)', 'year' => 5, 'semester' => 2],
        ];

        foreach ($courses as $c) {
            $course = Course::create([
                'title' => $c['title'],
                'code' => $c['code'],
                'year' => $c['year'],
                'semester' => $c['semester'],
                'description' => 'Course description for ' . $c['title'],
            ]);
            // Link to Computer Engineering
            $course->departments()->attach($compDept->id);
        }

        // 5. Create 3 Workshops
        $workshop1 = Workshop::create([
            'title' => 'Introduction to Laravel 11',
            'date' => '2026-07-01',
            'location' => 'Main Campus - Hall A',
            'capacity' => 100,
            'status' => 'upcoming',
            'category' => 'Web Development',
            'description' => 'Learn the basics of Laravel 11 and how to build modern web applications.',
            'time' => '10:00 AM',
            'duration' => 3,
            'type' => 'offline',
            'instructor_name' => 'Eng. Ahmad',
            'user_id' => $admin->id
        ]);

        $workshop2 = Workshop::create([
            'title' => 'Advanced React Patterns',
            'date' => '2026-07-15',
            'location' => 'Online (Zoom)',
            'capacity' => 50,
            'status' => 'upcoming',
            'category' => 'Frontend',
            'description' => 'Deep dive into React hooks, context, and performance optimization.',
            'time' => '04:00 PM',
            'duration' => 2,
            'type' => 'online',
            'instructor_name' => 'Eng. Sarah',
            'user_id' => $admin->id
        ]);

        $workshop3 = Workshop::create([
            'title' => 'AI in Engineering',
            'date' => '2026-08-01',
            'location' => 'Engineering Building - Lab 3',
            'capacity' => 30,
            'status' => 'upcoming',
            'category' => 'Artificial Intelligence',
            'description' => 'How AI is changing the landscape of modern engineering and problem solving.',
            'time' => '01:00 PM',
            'duration' => 4,
            'type' => 'offline',
            'instructor_name' => 'Dr. Khalid',
            'user_id' => $compUser->id
        ]);

        $workshop1->departments()->attach([$compDept->id, $elecDept->id, $civilDept->id]);
        $workshop2->departments()->attach([$compDept->id]);
        $workshop3->departments()->attach([$compDept->id, $elecDept->id]);
    }
}
