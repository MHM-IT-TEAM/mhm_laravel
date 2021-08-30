<?php

namespace Database\Seeders;

use App\Models\ServicePrice;
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
        ServicePrice::insert([
            [
                'name'=>'General Doctor consultation',
                'consultation_type_id'=>1,
                'sector'=>500,
                'out_sector'=>3000,
            ],
            [
                'name'=>'Dermatology consultation',
                'consultation_type_id'=>13,
                'sector'=>500,
                'out_sector'=>3000,
            ],
            [
                'name'=>'Injury/Wound care',
                'consultation_type_id'=>14,
                'sector'=>500,
                'out_sector'=>3000,
            ],
            [
                'name'=>'Dental consultation',
                'consultation_type_id'=>2,
                'sector'=>1000,
                'out_sector'=>1000,
            ],
            [
                'name'=>'Dental tooth extraction/ adult',
                'consultation_type_id'=>2,
                'sector'=>1000,
                'out_sector'=>5000,
            ],
            [
                'name'=>'Dental tooth extraction /milk tooth',
                'consultation_type_id'=>2,
                'sector'=>1000,
                'out_sector'=>2000,
            ],
            [
                'name'=>'Dental tooth cleaning',
                'consultation_type_id'=>2,
                'sector'=>1000,
                'out_sector'=>8000,
            ],
            [
                'name'=>'Dental tooth care',
                'consultation_type_id'=>2,
                'sector'=>1000,
                'out_sector'=>10000,
            ],
            [
                'name'=>'Dental follow-up tooth care',
                'consultation_type_id'=>2,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Ultrasound',
                'consultation_type_id'=>6,
                'sector'=>500,
                'out_sector'=>15000,
            ],
            [
                'name'=>'First CPN < 12 Weeks',
                'consultation_type_id'=>4,
                'sector'=>500,
                'out_sector'=>120000,
            ],
            [
                'name'=>'First CPN > 12 Weeks',
                'consultation_type_id'=>4,
                'sector'=>120000,
                'out_sector'=>250000,
            ],
            [
                'name'=>'First CPN > 20 Weeks',
                'consultation_type_id'=>4,
                'sector'=>250000,
                'out_sector'=>500000,
            ],
            [
                'name'=>'Follow-up CPN',
                'consultation_type_id'=>5,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Post partum baby',
                'consultation_type_id'=>8,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Post partum mom',
                'consultation_type_id'=>8,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Post partum meeting',
                'consultation_type_id'=>8,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Vaccination',
                'consultation_type_id'=>10,
                'sector'=>0,
                'out_sector'=>0,
            ],
            [
                'name'=>'Milk program',
                'consultation_type_id'=>12,
                'sector'=>5000,
                'out_sector'=>5000,
            ],
            [
                'name'=>'Baby Checkup',
                'consultation_type_id'=>11,
                'sector'=>500,
                'out_sector'=>5000,
            ],

        ]);
    }
}
