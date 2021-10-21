<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::insert([
            ['firstName'=>'Didi','lastName'=>'Randria','called'=>'Didi','employee_occupation_id'=>9],
            ['firstName'=>'Toky','lastName'=>'Rajao','called'=>'Toky','employee_occupation_id'=>9],
            ['firstName'=>'nadege','lastName'=>'Rova','called'=>'Nadege','employee_occupation_id'=>2],
            ['firstName'=>'manitra','lastName'=>'fitia','called'=>'Manitra','employee_occupation_id'=>1],
        ]);
    }
}
