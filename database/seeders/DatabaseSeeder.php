<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or update admin account
        User::updateOrCreate(
            ['email' => 'admin@app.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create or update regular user account
        User::updateOrCreate(
            ['email' => 'user@app.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'role' => 'pengguna',
            ]
        );
    }
}
