<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Khác', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hấp', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Xào', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kho', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Đồ ngọt', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chiên', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
