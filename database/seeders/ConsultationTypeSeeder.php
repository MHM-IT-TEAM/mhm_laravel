<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class consultationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('patSyst')->table('consultation_types')->insert([
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
                'name'=>'Milk /Food Program'
            ],
            [
                'name'=>'Dermatology'
            ],
            [
                'name'=>'Injury/Wound care'
            ]
        ]);
    }
}
