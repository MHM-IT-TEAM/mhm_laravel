<?php

namespace Database\Seeders;

use App\Models\InternalConsultationType;
use Illuminate\Database\Seeder;

class InternalConsultationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InternalConsultationType::insert([
            ['name'=>'Anesthetist'],
            ['name'=>'Senior'],
            ['name'=>'Ultrasound'],
            ['name'=>'CTG'],
            ['name'=>'Nebulizer'],
            ['name'=>'Vaccination'],
        ]);
    }
}
