<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Amal Elmi',
            'email' => 'amal@test.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Antoine',
            'email' => 'antoine@test.com',
            'password' => bcrypt('password'),
        ]);
    }
}