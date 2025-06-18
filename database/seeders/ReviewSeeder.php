<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'customer_id' => 1,
                'food_id' => 1, // Gà Rán
                'rating' => 5,
                'text' => 'Món gà rán rất ngon và giòn.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 2,
                'food_id' => 4, // Mì Xào Hải Sản
                'rating' => 4,
                'text' => 'Mì xào hải sản khá ngon, nhưng hơi ít hải sản.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
