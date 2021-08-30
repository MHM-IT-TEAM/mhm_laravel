<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class typeConsultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('patSyst')->table('type_consults')->insert([
            [
                'name'=>'Generalist'
            ],
            [
                'name'=>'Dentist'
            ],
            [
                'name'=>'Family Planning'
            ],
            [
                'name'=>'CPN Admission'
            ],
            [
                'name'=>'CPN Followup'
            ],
            [
                'name'=>'Ultrasound'
            ],
            [
                'name'=>'Post Partum mom'
            ],
            [
                'name'=>'Post partum baby'
            ],
            [
                'name'=>'Post partum meeting'
            ],
            [
                'name'=>'Vaccination'
            ],
            [
                'name'=>'Baby Checkup'
            ],
            [
                'name'=>'Dermatology'
            ],
            [
                'name'=>'Milk Program'
            ],

            [
                'name'=>'Injury/Wound care'
            ],
            [
                'name'=>'Ophthalmology'
            ]

        ]);
    }
}
