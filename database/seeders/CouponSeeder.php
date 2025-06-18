<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coupons')->insert([
            [
                'name' => 'GIAM20K',
                'description' => 'Miễn phí 20k cho đơn hàng trên 100k',
                'min_order_value' => 100000.00,
                'discount' => 20000.00, // Assuming a fixed free shipping cost
                'quantity' => 100,
                'expire_date' => '2026-12-31 23:59:59',
                'is_public' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'GIAM50K',
                'description' => 'Giảm 50k cho đơn hàng trên 200k',
                'min_order_value' => 200000.00,
                'discount' => 50000.00,
                'quantity' => 50,
                'expire_date' => '2026-11-30 23:59:59',
                'is_public' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
