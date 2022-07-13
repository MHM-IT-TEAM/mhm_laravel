<?php

namespace Database\Seeders;

use App\Models\inventory_system\Collector;
use Illuminate\Database\Seeder;

class CollectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Collector::insert([
            ['name'=>'Saholy','department_id'=>1],
            ['name'=>'Tianasoa','department_id'=>4],
            ['name'=>'Hasina','department_id'=>2],

        ]);
    }
}
