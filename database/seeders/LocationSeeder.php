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
            ['name'=>'Antiseptic Shelf'],//1
            ['name'=>'Mucocutaneous shelf'],//2
            ['name'=>'Enteral shelf'],//3
            ['name'=>'Parenteral shelf'],//4
            ['name'=>'Syrup shelf'],//5
            ['name'=>'Dental drawer'],//6
            ['name'=>'Anesthetist shelf'],//7
            ['name'=>'Fridge'],//8
            ['name'=>'PF Shelf L1'],//9
            ['name'=>'PF Shelf M1'],//9
            ['name'=>'Serum shelf'],//10
            ['name'=>'Nursie shelf B1'],//10

        ]);
    }
}
