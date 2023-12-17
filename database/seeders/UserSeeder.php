<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'username' => 'admin',
            'password' => 'Admin123!',
            'role' => 'ROLE_ADMIN'
        ]);
    }
}
