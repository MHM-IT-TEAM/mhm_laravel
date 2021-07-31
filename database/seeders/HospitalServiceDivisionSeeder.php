<?php

namespace Database\Seeders;

use App\Models\HospitalServiceDivision;
use Illuminate\Database\Seeder;

class HospitalServiceDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HospitalServiceDivision::insert([
            ['name'=>'Maternity Normal Care','hospital_service_id'=>1],
            ['name'=>'Maternity Medium Care','hospital_service_id'=>1],
            ['name'=>'Maternity Intensive Care','hospital_service_id'=>1],
        ]);
    }
}
