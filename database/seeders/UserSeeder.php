<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'password' => Hash::make('secret123'),
            ],
            [
                'username' => 'jane_smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('mypassword'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
