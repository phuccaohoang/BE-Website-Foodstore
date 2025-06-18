<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('administrators')->insert([
            [
                'fullname' => 'Quản trị viên',
                'account_id' => 1, // Assuming account_id 3 is for admin@example.com
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
