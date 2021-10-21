<?php

namespace Database\Seeders;

use App\Models\EmployeeOccupation;
use Illuminate\Database\Seeder;

class EmployeeOccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeeOccupation::insert([
            ['name'=>'midwife'],
            ['name'=>'nurse'],
            ['name'=>'anesthetist'],
            ['name'=>'generalist doctor'],
            ['name'=>'dentist doctor'],
            ['name'=>'Senior midwife'],
            ['name'=>'Senior medical'],
            ['name'=>'pharmacist'],
            ['name'=>'driver'],
            ['name'=>'mechanic'],
            ['name'=>'gynecologist'],
            ['name'=>'dermatologist'],
            ['name'=>'surgeon'],
            ['name'=>'midwife-assistant'],
            ['name'=>'nurse-assistant'],
        ]);
    }
}
