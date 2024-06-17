<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'pt',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 30; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'role' => $faker->randomElement(['student', 'pt']),
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }
    }
}
