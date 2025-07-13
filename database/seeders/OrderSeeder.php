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
                'delivery_cost' => 15000.00,
                'coupon_id' => 1,
                'note' => null,
                'is_payment' => 1,
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
                'delivery_cost' => 15000.00,
                'coupon_id' => null,
                'note' => null,
                'is_payment' => 1,
                'order_status_id' => 4, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 1,
                'phone' => '0987654321',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'total_amount' => 200000.00,
                'quantity' => 4,
                'delivery_cost' => 15000.00,
                'coupon_id' => 1,
                'note' => null,
                'is_payment' => 1,
                'order_status_id' => 4, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'phone' => '0987654444',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'total_amount' => 230000.00,
                'quantity' => 4,
                'delivery_cost' => 15000.00,
                'coupon_id' => 1,
                'note' => null,
                'is_payment' => 1,
                'order_status_id' => 4, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [ // 5
                'customer_id' => 4,
                'phone' => '0987654422',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'total_amount' => 60000.00,
                'quantity' => 4,
                'delivery_cost' => 15000.00,
                'coupon_id' => null,
                'note' => null,
                'is_payment' => 1,
                'order_status_id' => 4, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [ // 6
                'customer_id' => 4,
                'phone' => '0987654422',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'total_amount' => 80000.00,
                'quantity' => 4,
                'delivery_cost' => 15000.00,
                'coupon_id' => null,
                'note' => null,
                'is_payment' => 1,
                'order_status_id' => 4, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [ // 7
                'customer_id' => 3,
                'phone' => '0987654333',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'total_amount' => 45000.00,
                'quantity' => 1,
                'delivery_cost' => 15000.00,
                'coupon_id' => null,
                'note' => null,
                'is_payment' => 1,
                'order_status_id' => 4, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [ // 8
                'customer_id' => 2,
                'phone' => '0987654222',
                'address' => '123 Đường ABC, Quận 3, TP.HCM',
                'total_amount' => 200000.00,
                'quantity' => 6,
                'delivery_cost' => 15000.00,
                'coupon_id' => 1,
                'note' => null,
                'is_payment' => 1,
                'order_status_id' => 4, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [ // 9
                'customer_id' => 5,
                'phone' => '0987654214',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'total_amount' => 150000.00,
                'quantity' => 3,
                'delivery_cost' => 15000.00,
                'coupon_id' => 1,
                'note' => null,
                'is_payment' => 1,
                'order_status_id' => 4, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [ // 10
                'customer_id' => 5,
                'phone' => '0987654214',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'total_amount' => 100000.00,
                'quantity' => 4,
                'delivery_cost' => 15000.00,
                'coupon_id' => 1,
                'note' => null,
                'is_payment' => 1,
                'order_status_id' => 4, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [ // 11
                'customer_id' => 5,
                'phone' => '0987654214',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'total_amount' => 180000.00,
                'quantity' => 6,
                'delivery_cost' => 15000.00,
                'coupon_id' => 1,
                'note' => null,
                'is_payment' => 1,
                'order_status_id' => 4, // Đang giao
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
