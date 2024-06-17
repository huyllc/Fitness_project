<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('enrollments')->truncate();
        
        $students = User::where('role', 'student')->get();

        $courses = Course::all();

        foreach ($students as $student) {
            foreach ($courses as $course) {
                if (rand(0, 1)) {
                    Enrollment::create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'completed' => rand(0, 1),
                        'completed_day' => now()->subDays(rand(1, 30)),
                        'status' => rand(0, 1),
                    ]);
                }
            }
        }
    }
}
