<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UltrasoundAdditionalScreeningReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ultrasound_additional_screening_reasons')->insert([
            [
                'name' => 'Abnormal findings in prenatal care'
            ],
            [
                'name' => 'Center complications'
            ],
            [
                'name' => 'Lack of baby movements'
            ],
            [
                'name' => 'High blood pressure'
            ],
            [
                'name' => 'Growth retardation'
            ],
            [
                'name' => 'Accidents'
            ],
            [
                'name' => 'Other'
            ],
        ]);
    }
}
