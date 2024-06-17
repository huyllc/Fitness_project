<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profiles')->truncate();

        $users = User::all();
        foreach ($users as $user) {
            $totalStudent = $user->role === 'pt' ? rand(1, 100) : null;
            $rating = $user->role === 'pt' ? rand(1,5) : null;
            Profile::create([
                'user_id' => $user->id,
                'description' =>  "Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of de Finibus Bonorum et Malorum (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, Lorem ipsum dolor sit amet.., comes from a line in section 1.10.32.,",
                'rating' => $rating,
                'total_student' => $totalStudent,
                'sex' => rand(0, 1),
                'birthday' => now()->subYears(rand(18, 60))->subDays(rand(1, 365)),
                'picture' => 'DefaultAvatar.png',
            ]);
        }
    }
}
