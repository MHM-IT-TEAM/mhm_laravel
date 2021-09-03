<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert([
            ['name'=>'General','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Dermatology','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Injury/Wound care','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Vaccination','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Dental','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Ophthalmology','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Obstetrical ultrasound','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Obstetrical first cpn','service_id'=>1,'joyCenter_visible'=>0],
            ['name'=>'Obstetrical cpn followup','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Obstetrical postpartum baby','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Obstetrical postpartum mom','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Obstetrical postpartum meeting','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'Obstetrical family planning','service_id'=>1,'joyCenter_visible'=>1],
            ['name'=>'General','service_id'=>2,'joyCenter_visible'=>1],
            ['name'=>'Dental','service_id'=>2,'joyCenter_visible'=>1],
            ['name'=>'Obstetrical','service_id'=>2,'joyCenter_visible'=>1],
            ['name'=>'Pediatric','service_id'=>2,'joyCenter_visible'=>1],
            ['name'=>'Other','service_id'=>2,'joyCenter_visible'=>1],
            ['name'=>'Deliveries','service_id'=>3,'joyCenter_visible'=>1],
            ['name'=>'Surgeries C-section','service_id'=>4,'joyCenter_visible'=>1],
            ['name'=>'Surgeries EUG other','service_id'=>4,'joyCenter_visible'=>1],
            ['name'=>'Vaccination','service_id'=>6,'joyCenter_visible'=>1],
            ['name'=>'Routine checkup','service_id'=>6,'joyCenter_visible'=>1],
            ['name'=>'Sickness','service_id'=>6,'joyCenter_visible'=>1],
            ['name'=>'Injury/Wound care','service_id'=>6,'joyCenter_visible'=>1],
            ['name'=>'Milk program','service_id'=>6,'joyCenter_visible'=>1],
        ]);
    }
}
