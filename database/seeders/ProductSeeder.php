<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_details')->insert([
            [
                'product_name' => 'Gold coffee',
                'profile_margin_in_percentage' => 25,
                'shipping_cost' => 10.00
            ],
            [
                'product_name' => 'Arabic coffee',
                'profile_margin_in_percentage' => 15,
                'shipping_cost' => 10.00
            ]
        ]);
    }
}
