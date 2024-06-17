<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{

    public function run(): void
    {

        Admin::truncate();

        Admin::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}

