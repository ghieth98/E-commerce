<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'code' => 'ABC',
            'type' =>  'fixed',
            'value' => 50,
            ]);

        Coupon::create([
            'code' => 'DFG',
            'type' =>  'percent',
            'present_off' => 60,
        ]);
    }
}
