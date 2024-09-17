<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   
    public function run(): void{
     $users= [
        [
            'name' => 'youssef',
            'email' => 'admin@gmail.com',
            'role_user' => 'Admin',
            'password' => bcrypt('12345678'),
        ],
        [
            'name' => 'Ahmed',
            'email' => 'manager@gmail.com',
            'role_user' => 'Manager',
            'password' => bcrypt('12345678'),
        ],
        [
            'name' => 'ali',
            'email' => 'user@gmail.com',
            'role_user' => 'user',
            'password' => bcrypt('12345678'),
        ],
        [
            'name' => 'mohamd',
            'email' => 'user2@gmail.com',
            'role_user' => 'user',
            'password' => bcrypt('12345678'),
        ],
        [
            'name' => 'ahmad',
            'email' => 'user3@gmail.com',
            'role_user' => 'user',
            'password' => bcrypt('12345678'),
        ],
    ];
    foreach ($users as $user) {
        User::create($user);
    }
}
    }

