<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the assignments table to start fresh
        Assignment::truncate();

        // Get all courses
        $courses = Course::all();

        // Generate fake assignments
        foreach ($courses as $course) {
            $numberOfAssignments = rand(0, 5);
            for ($i = 0; $i < $numberOfAssignments; $i++) {
                Assignment::create([
                    'course_id' => $course->id,
                    'link_video' => 'rick.mp4',
                    'title' => 'Assignment ' . ($i + 1),
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                ]);
            }
        }
    }
}
