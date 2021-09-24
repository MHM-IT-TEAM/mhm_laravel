<?php

namespace Database\Seeders;

use App\Models\inventory_system\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::insert([
            ['name'=>'A1'],//1
            ['name'=>'A2'],//2
            ['name'=>'A3'],//3
            ['name'=>'A4'],//4
            ['name'=>'B'],//5
            ['name'=>'B'],//6
            ['name'=>'C'],//7
            ['name'=>'Anesthesia self'],//8
            ['name'=>'Cream drawer'],//9
            ['name'=>'Dental drawer'],//10

        ]);
    }
}
