<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarParkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rent_cars')->insert([
            'created_at' => date('c'),
            'updated_at' => date('c'),
            'brand' => 'KIA RIO',
            'yearProduce' => 2022,
            'carMileage' => 5000,
            'color' => 'black',
            'active' => true,
            'renovation' => false,
            'rented'=> true
        ]);
    }
}
