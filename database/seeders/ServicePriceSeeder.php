<?php

namespace Database\Seeders;

use App\Models\ActivityPrice;
use Illuminate\Database\Seeder;

class ServicePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActivityPrice::insert([
            [
                'name'=>'General',
                'section_id'=>1,
                'sector'=>500,
                'out_sector'=>3000,
            ],
            [
                'name'=>'Dermatology',
                'section_id'=>2,
                'sector'=>500,
                'out_sector'=>3000,
            ],
            [
                'name'=>'Injury/Wound care',
                'section_id'=>3,
                'sector'=>500,
                'out_sector'=>3000,
            ],
            [
                'name'=>'Vaccination',
                'section_id'=>4,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Dental consultation',
                'section_id'=>5,
                'sector'=>1000,
                'out_sector'=>1000,
            ],
            [
                'name'=>'Dental extraction adult',
                'section_id'=>5,
                'sector'=>0,
                'out_sector'=>5000,
            ],
            [
                'name'=>'Dental extraction milk-tooth',
                'section_id'=>5,
                'sector'=>0,
                'out_sector'=>2000,
            ],
            [
                'name'=>'Dental cleaning',
                'section_id'=>5,
                'sector'=>0,
                'out_sector'=>8000,
            ],
            [
                'name'=>'Dental first treatment',
                'section_id'=>5,
                'sector'=>0,
                'out_sector'=>10000,
            ],
            [
                'name'=>'Dental treatment followup',
                'section_id'=>5,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Ophthalmology',
                'section_id'=>6,
                'sector'=>500,
                'out_sector'=>5000,
            ],
            [
                'name'=>'Obstetrical first cpn < 12 weeks',
                'section_id'=>8,
                'sector'=>500,
                'out_sector'=>120000,
            ],
            [
                'name'=>'Obstetrical first cpn > 12 weeks',
                'section_id'=>8,
                'sector'=>120000,
                'out_sector'=>250000,
            ],
            [
                'name'=>'Obstetrical first cpn >20 weeks',
                'section_id'=>8,
                'sector'=>250000,
                'out_sector'=>500000,
            ],
            [
                'name'=>'Obstetrical cpn followup',
                'section_id'=>9,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'Obstetrical postpartum baby',
                'section_id'=>10,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'Obstetrical postpartum mom',
                'section_id'=>11,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'Obstetrical postpartum meeting',
                'section_id'=>12,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'Obstetrical family planning',
                'section_id'=>13,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'General',
                'section_id'=>14,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'Dental',
                'section_id'=>15,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'Obstetrical',
                'section_id'=>16,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'Pediatric',
                'section_id'=>17,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'Other',
                'section_id'=>14,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'Deliveries',
                'section_id'=>19,
                'sector'=>null,
                'out_sector'=>null,
            ],
            [
                'name'=>'Surgeries C-section',
                'section_id'=>20,
                'sector'=>350000,
                'out_sector'=>700000,
            ],
            [
                'name'=>'Surgeries EUG Other',
                'section_id'=>21,
                'sector'=>500000,
                'out_sector'=>1000000,
            ],
            [
                'name'=>'Pediatric vaccination',
                'section_id'=>22,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Pediatric routine checkup',
                'section_id'=>23,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Pediatric sickness',
                'section_id'=>24,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Pediatric injury/Wound care',
                'section_id'=>25,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Pediatric milk program',
                'section_id'=>26,
                'sector'=>5000,
                'out_sector'=>5000,
            ],

        ]);
    }
}
