<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin-griyanet',
                'email' => 'admin.griyanet@gmail.com',
                'password' => bcrypt('password'),
                'role' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
