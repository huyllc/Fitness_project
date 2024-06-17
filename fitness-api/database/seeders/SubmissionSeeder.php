<?php

namespace Database\Seeders;

use App\Models\Submission;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the submissions table to start fresh
        Submission::truncate();

        // Get all assignments and users
        $assignments = Assignment::all();
        $users = User::all();

        // Generate fake submissions
        foreach ($assignments as $assignment) {
            $numberOfSubmissions = rand(0, 10);
            for ($i = 0; $i < $numberOfSubmissions; $i++) {
                $user = $users->random();
                Submission::create([
                    'assignment_id' => $assignment->id,
                    'student_id' => $user->id,
                    'grade' => rand(0, 10),
                    'feed_back' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'link_video' => 'rick.mp4',
                ]);
            }
        }
    }
}
