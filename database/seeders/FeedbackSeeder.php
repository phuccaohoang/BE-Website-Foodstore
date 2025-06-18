<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('feedbacks')->insert([
            [
                'administrator_id' => 1,
                'review_id' => 1, // Review của customer 1 về Gà Rán
                'text' => 'Cảm ơn bạn đã đánh giá món ăn của chúng tôi!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'administrator_id' => 1,
                'review_id' => 2, // Review của customer 2 về Mì Xào Hải Sản
                'text' => 'Chúng tôi sẽ cải thiện lượng hải sản trong món mì xào. Cảm ơn phản hồi của bạn!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
