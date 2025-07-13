<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_details')->insert([
            [
                'order_id' => 1,
                'food_id' => 1, // Gà Rán
                'price' => 50000.00,
                'discount' => 10,
                'quantity' => 1,
                'is_review' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 1,
                'food_id' => 2, // Chả Giò
                'price' => 30000.00,
                'discount' => 0,
                'quantity' => 1,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'food_id' => 3, // Bánh Bao
                'price' => 15000.00,
                'discount' => 0,
                'quantity' => 2,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'food_id' => 4, // Mì Xào Hải Sản
                'price' => 65000.00,
                'discount' => 5,
                'quantity' => 1,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 3,
                'food_id' => 1,
                'price' => 50000.00,
                'discount' => 0,
                'quantity' => 4,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 4,
                'food_id' => 1,
                'price' => 50000.00,
                'discount' => 0,
                'quantity' => 2,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 4,
                'food_id' => 4,
                'price' => 65000.00,
                'discount' => 0,
                'quantity' => 2,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 5,
                'food_id' => 3,
                'price' => 15000.00,
                'discount' => 0,
                'quantity' => 4,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 6,
                'food_id' => 6,
                'price' => 20000.00,
                'discount' => 0,
                'quantity' => 4,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 7,
                'food_id' => 9,
                'price' => 45000.00,
                'discount' => 0,
                'quantity' => 1,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 8,
                'food_id' => 15,
                'price' => 25000.00,
                'discount' => 0,
                'quantity' => 4,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 8,
                'food_id' => 1,
                'price' => 50000.00,
                'discount' => 0,
                'quantity' => 2,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 9,
                'food_id' => 1,
                'price' => 50000.00,
                'discount' => 0,
                'quantity' => 3,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 10,
                'food_id' => 13,
                'price' => 25000.00,
                'discount' => 0,
                'quantity' => 4,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 11,
                'food_id' => 16,
                'price' => 20000.00,
                'discount' => 0,
                'quantity' => 4,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 11,
                'food_id' => 1,
                'price' => 50000.00,
                'discount' => 0,
                'quantity' => 2,
                'is_review' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
