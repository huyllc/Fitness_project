<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the comments table to start fresh
        DB::table('comments')->truncate();

        // Get all users and courses
        $users = User::where('role', 'student')->get();
        $courses = Course::all();

        // Generate fake comments
        foreach ($courses as $course) {
            $numberOfComments = rand(0, 10);
            for ($i = 0; $i < $numberOfComments; $i++) {
                $user = $users->random();
                Comment::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'rate' => rand(1, 5),
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'is_published' => true,
                ]);
            }
        }
    }
}
