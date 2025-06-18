<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Feedback;
use App\Models\OrderDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AccountSeeder::class,
            AdministratorSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            FoodSeeder::class,
            CartSeeder::class,
            CouponSeeder::class,
            ImageSeeder::class,
            OrderStatusSeeder::class,
            OrderSeeder::class,
            OrderDetailSeeder::class,
            ReviewSeeder::class,
            FeedbackSeeder::class
        ]);
    }
}
