<?php

namespace Database\Seeders;

use App\Models\User;
use App\Helpers\RoleHelper;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => 'password123', // hashed by Eloquent cast
                'role' => RoleHelper::ROLE_ADMIN,
            ]
        );

        // Kasir account
        User::updateOrCreate(
            ['email' => 'kasir@example.com'],
            [
                'name' => 'Kasir',
                'password' => 'password123', // hashed by Eloquent cast
                'role' => RoleHelper::ROLE_KASIR,
            ]
        );
    }
}
