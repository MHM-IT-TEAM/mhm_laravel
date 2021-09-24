<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert([
            ['name'=>'admin'],
            ['name'=>'Grace Center'],
            ['name'=>'Stork Center'],
            ['name'=>'Block'],
            ['name'=>'MidPink'],
            ['name'=>'Anesthetist'],
            ['name'=>'Ambulance'],
            ['name'=>'Gl Doctor'],
            ['name'=>'Dent Doctor'],
            ['name'=>'Dent Mob'],
            ['name'=>'Gl Mob'],
            ['name'=>'mid Mob'],
            ['name'=>'office'],
            ['name'=>'JoyCenter'],
            ['name'=>'House Hold'],
            ['name'=>'Technicals'],
        ]);
    }
}
