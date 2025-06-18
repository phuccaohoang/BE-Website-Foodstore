<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assuming category IDs: Chiên=1, Hấp=2, Xào=3, Kho=4, Đồ ngọt=5, Khác=6
        DB::table('foods')->insert([
            [
                'name' => 'Gà Rán',
                'slug' => Str::slug('Gà Rán'),
                'category_id' => 1, // Chiên
                'description' => 'Gà rán giòn rụm thơm ngon.',
                'price' => 50000.00,
                'sold' => 150,
                'discount' => 10,
                'rating' => 4.50,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chả Giò',
                'slug' => Str::slug('Chả Giò'),
                'category_id' => 1, // Chiên
                'description' => 'Chả giò truyền thống, vỏ giòn rụm.',
                'price' => 30000.00,
                'sold' => 120,
                'discount' => 0,
                'rating' => 4.20,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bánh Bao',
                'slug' => Str::slug('Bánh Bao'),
                'category_id' => 2, // Hấp
                'description' => 'Bánh bao nóng hổi nhân thịt.',
                'price' => 15000.00,
                'sold' => 100,
                'discount' => 0,
                'rating' => 4.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mì Xào Hải Sản',
                'slug' => Str::slug('Mì Xào Hải Sản'),
                'category_id' => 3, // Xào
                'description' => 'Mì xào hải sản tươi ngon, đậm đà.',
                'price' => 65000.00,
                'sold' => 80,
                'discount' => 5,
                'rating' => 4.70,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cá Kho Tộ',
                'slug' => Str::slug('Cá Kho Tộ'),
                'category_id' => 4, // Kho
                'description' => 'Cá kho tộ đậm chất quê hương.',
                'price' => 75000.00,
                'sold' => 60,
                'discount' => 0,
                'rating' => 4.80,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bánh Donut',
                'slug' => Str::slug('Bánh Donut'),
                'category_id' => 5, // Đồ ngọt
                'description' => 'Bánh donut mềm xốp nhiều vị.',
                'price' => 20000.00,
                'sold' => 200,
                'discount' => 0,
                'rating' => 4.10,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Snack Khoai Tây',
                'slug' => Str::slug('Snack Khoai Tây'),
                'category_id' => 6, // Khác
                'description' => 'Snack khoai tây giòn tan.',
                'price' => 10000.00,
                'sold' => 300,
                'discount' => 0,
                'rating' => 3.90,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
