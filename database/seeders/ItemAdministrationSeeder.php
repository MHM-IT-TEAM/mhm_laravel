<?php

namespace Database\Seeders;

use App\Models\inventory_system\ItemAdministration;
use Illuminate\Database\Seeder;

class ItemAdministrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemAdministration::insert([
           ['name'=>'Oral'],//1
           ['name'=>'Injection'],//2
           ['name'=>'Sublingualy'],//3
           ['name'=>'Bucally'],//4
           ['name'=>'Rectally'],//5
           ['name'=>'Vaginally'],//6
           ['name'=>'Ocular'],//7
           ['name'=>'Nasal'],//8
           ['name'=>'Inhalation'],//9
           ['name'=>'Nebulization'],//10
           ['name'=>'Cutaneous'],//11
           ['name'=>'Transdermally'],//12
           ['name'=>'mixed'],//13
        ]);
    }
}
