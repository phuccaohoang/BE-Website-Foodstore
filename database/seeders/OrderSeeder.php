<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'customer_id' => 1,
                'phone' => '0912345678',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'total_amount' => 100000.00,
                'quantity' => 2,
                'delivery_cost' => 25000.00,
                'coupon_id' => 1,
                'note' => 'Giao hàng buổi chiều',
                'order_status_id' => 4, // Đã giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 2,
                'phone' => '0987654321',
                'address' => '456 Đường XYZ, Quận 3, TP.HCM',
                'total_amount' => 150000.00,
                'quantity' => 3,
                'delivery_cost' => 25000.00,
                'coupon_id' => null,
                'note' => null,
                'order_status_id' => 3, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
