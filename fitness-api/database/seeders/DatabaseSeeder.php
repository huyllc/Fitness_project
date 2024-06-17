<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProfileSeeder::class,
            CourseSeeder::class,
            EnrollmentSeeder::class,
            SubmissionSeeder::class,
            AssignmentSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
