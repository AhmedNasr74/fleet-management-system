<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i < 100; $i++) {
            User::updateOrCreate(['email' => 'user' . $i . '@example.com'], [
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => bcrypt('password')
            ]);
        }
    }
}
