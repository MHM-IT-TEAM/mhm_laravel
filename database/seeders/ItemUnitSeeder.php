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
            ['name'=>'Powder'],
            ['name'=>'Opthalmic Gel'],
            ['name'=>'Tablets'],
            ['name'=>'Suppository'],
            ['name'=>'Ampoule'],
            ['name'=>'Syrup'],
            ['name'=>'Paste'],
            ['name'=>'Liquid'],
            ['name'=>'Cream'],
            ['name'=>'Gel'],
            ['name'=>'Intravenous Drip'],
            ['name'=>'Spray'],
            ['name'=>'Gas'],
            ['name'=>'Liquid-oral'],
            ['name'=>'Ovula'],
            ['name'=>'Lotion'],
            ['name'=>'Tige'],
            ['name'=>'Nasal Spray'],
            ['name'=>'Gelatin'],
            ['name'=>'Heavy cream'],
            ['name'=>'Gels'],
            ['name'=>'Collures'],
            ['name'=>'Cream'],
            ['name'=>'unit'],

        ]);
    }
}
