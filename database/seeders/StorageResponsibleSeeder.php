<?php

namespace Database\Seeders;

use App\Models\inventory_system\StorageResponsible;
use Illuminate\Database\Seeder;

class StorageResponsibleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StorageResponsible::insert([
            ['name'=>'Dhalia'],
            ['name'=>'Tsiferana'],
        ]);
    }
}
