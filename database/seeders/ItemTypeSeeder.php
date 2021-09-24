<?php

namespace Database\Seeders;

use App\Models\inventory_system\ItemType;
use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemType::insert([
            ['name'=>'Medicine'],
            ['name'=>'Consumables'],
        ]);
    }
}
