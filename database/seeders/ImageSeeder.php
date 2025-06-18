<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert([
            [
                'food_id' => 1, // Gà Rán
                'img' => 'ga_ran_1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 1, // Gà Rán
                'img' => 'ga_ran_2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 2, // Chả Giò
                'img' => 'cha_gio_1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 3, // Bánh Bao
                'img' => 'banh_bao_1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 4, // Mì Xào Hải Sản
                'img' => 'mi_xao_hai_san_1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 5, // Cá Kho Tộ
                'img' => 'ca_kho_to_1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 6, // Bánh Donut
                'img' => 'banh_donut_1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_id' => 7, // Snack Khoai Tây
                'img' => 'snack_khoai_tay_1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
