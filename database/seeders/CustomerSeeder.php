<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'fullname' => 'Nguyễn Văn A',
                'phone' => '0912345678',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'account_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => 'Trần Thị B',
                'phone' => '0987654321',
                'address' => '456 Đường XYZ, Quận 3, TP.HCM',
                'account_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
