<?php

namespace Database\Seeders;

use App\Models\inventory_system\ItemUnit;
use Illuminate\Database\Seeder;

class ItemUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemUnit::insert([
            ['name'=>'Ampoule'],//1
            ['name'=>'Bar'],//2
            ['name'=>'Bidon'],//3
            ['name'=>'Bottle'],//4
            ['name'=>'Box'],//5
            ['name'=>'Capsule'],//6
            ['name'=>'Cream'],//7
            ['name'=>'Dose'],//8
            ['name'=>'Drop'],//9
            ['name'=>'Gelule'],//10
            ['name'=>'Injection'],//11
            ['name'=>'Ovule'],//12
            ['name'=>'pack'],//13
            ['name'=>'piece'],//14
            ['name'=>'sachet'],//15
            ['name'=>'pill'],//16
            ['name'=>'Tube'],//17
            ['name'=>'Paste'],//18
            ['name'=>'Spray'],//19
            ['name'=>'Inhalation'],//20
            ['name'=>'Suppo']//21

        ]);
    }
}
