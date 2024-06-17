<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->truncate();
        Course::create([
            'user_id' => 1,
            'title' => "Fitness Course improving arm muscle",
            'description' => "Body Sculpting: Shaping Your Physique: This course focuses on sculpting your body through targeted exercises and workout routines. Learn how to emphasize muscle definition, symmetry, and proportions to achieve your desired physique goals",
            'duration' => 3,
            'thumbnail' => 'course.jpg',
            'is_published' => true,
        ]);
        Course::create([
            'user_id' => 1,
            'title' => "Advanced Muscle Building Techniques",
            'description' => "Advanced Muscle Building Techniques: Take your muscle-building efforts to the next level with advanced training methods, including progressive overload, intensity techniques, specialized workouts, and advanced nutrition strategies tailored for muscle growth.",
            'duration' => 7,
            'thumbnail' => 'course.jpg',
            'is_published' => true,
        ]);
        Course::create([
            'user_id' => 1,
            'title' => "Sports Nutrition for Peak Performance",
            'description' => "Sports Nutrition for Peak Performance: Explore advanced sports nutrition concepts tailored for athletes looking to optimize their performance. Learn about pre- and post-workout nutrition, hydration strategies, fueling for endurance events, and dietary supplements for enhancing athletic performance and recovery.",
            'duration' => 4,
            'thumbnail' => 'course.jpg',
            'is_published' => true,
        ]);
        Course::create([
            'user_id' => 1,
            'title' => "Flexibility and Mobility Training",
            'description' => "Flexibility and Mobility Training: Improve your flexibility, mobility, and range of motion with targeted stretching and mobility exercises. Learn about the importance of flexibility for injury prevention, posture correction, and enhancing athletic performance",
            'duration' => 3,
            'thumbnail' => 'course.jpg',
            'is_published' => true,
        ]);
        Course::create([
            'user_id' => 1,
            'title' => "Functional Fitness Workouts",
            'description' => "Functional Fitness Workouts: Explore functional fitness exercises and workouts designed to improve your overall strength, mobility, and agility for real-life activities and sports performance. Learn how to incorporate functional movements into your training routine for functional strength gains",
            'duration' => 10,
            'thumbnail' => 'course.jpg',
            'is_published' => true,
        ]);
        $ptUsers = User::where('role', 'pt')->get();
        foreach ($ptUsers as $user) {
            if($user->id == 1) {
                continue;
            }
            for ($i = 0; $i < 5; $i++) {
                Course::create([
                    'user_id' => $user->id,
                    'title' => 'Fitness Course ' . $i,
                    'description' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary,",
                    'duration' => rand(1, 12),
                    'thumbnail' => 'course.jpg',
                    'is_published' => true,
                ]);
            }
        }
    }
}
