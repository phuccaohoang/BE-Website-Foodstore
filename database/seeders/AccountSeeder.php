<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accounts')->insert([
            [
                'email' => 'admin@gmail.com',
                'password' => Hash::make('adminpassword'),
                'avatar' => null,
                'is_admin' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user1@gmail.com',
                'password' => Hash::make('password123'),
                'avatar' => null,
                'is_admin' => 0,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user2@gmail.com',
                'password' => Hash::make('password123'),
                'avatar' => null,
                'is_admin' => 0,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user3@gmail.com',
                'password' => Hash::make('password123'),
                'avatar' => null,
                'is_admin' => 0,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user4@gmail.com',
                'password' => Hash::make('password123'),
                'avatar' => null,
                'is_admin' => 0,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user5@gmail.com',
                'password' => Hash::make('password123'),
                'avatar' => null,
                'is_admin' => 0,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
