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
                "name"=>'GL Sector',
                "price"=>500,
                "type_consult_id"=>1,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'GL Other Sector',
                "price"=>3000,
                "type_consult_id"=>1,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Wound care Sector',
                "price"=>500,
                "type_consult_id"=>1,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Wound care other Sector',
                "price"=>3000,
                "type_consult_id"=>1,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Dentist Sector',
                "price"=>500,
                "type_consult_id"=>2,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Dentist extraction ',
                "price"=>5000,
                "type_consult_id"=>2,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Dentist Care ',
                "price"=>10000,
                "type_consult_id"=>2,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Dentist Cleaning ',
                "price"=>8000,
                "type_consult_id"=>2,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'CPN<12 Week Sector ',
                "price"=>500,
                "type_consult_id"=>4,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'CPN >12 Week Sector ',
                "price"=>120000,
                "type_consult_id"=>4,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'CPN<12 Week Other Sector',
                "price"=>120000,
                "type_consult_id"=>4,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'CPN>12 Week Other Sector',
                "price"=>250000,
                "type_consult_id"=>4,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'CPN >20 Week Other Sector',
                "price"=>350000,
                "type_consult_id"=>4,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'OC Other Sector',
                "price"=>700000,
                "type_consult_id"=>4,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Echo Other Sector',
                "price"=>500,
                "type_consult_id"=>4,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Dermato Sector',
                "price"=>500,
                "type_consult_id"=>9,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Dermato Other Sector',
                "price"=>3000,
                "type_consult_id"=>9,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Baby Checkup Sector',
                "price"=>0,
                "type_consult_id"=>8,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Baby Vaccination Sector',
                "price"=>0,
                "type_consult_id"=>8,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Baby Checkup Other Sector',
                "price"=>5000,
                "type_consult_id"=>8,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Baby Vaccination Other Sector',
                "price"=>5000,
                "type_consult_id"=>8,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'CPN Followup Sector',
                "price"=>1,
                "type_consult_id"=>11,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'CPN Followup Other Sector',
                "price"=>1,
                "type_consult_id"=>11,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Pregnancy Test',
                "price"=>500,
                "type_consult_id"=>4,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Pregnancy Test',
                "price"=>500,
                "type_consult_id"=>4,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Ultrasound',
                "price"=>500,
                "type_consult_id"=>5,
                "sector"=>1,
                "active"=>1,
                "created_at"=>now()
            ],
            [
                "name"=>'Ultrasound',
                "price"=>3000,
                "type_consult_id"=>5,
                "sector"=>0,
                "active"=>1,
                "created_at"=>now()
            ],


        ]);
    }
}
