<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_status')->insert([
            ['name' => 'Chờ xác nhận', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Đang chuẩn bị', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Đang giao', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Đã giao', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Đã hủy', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
