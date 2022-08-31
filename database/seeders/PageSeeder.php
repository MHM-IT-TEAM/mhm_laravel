<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::insert([
            ['description'=>'joyCenter','link'=>'joyCenter/admission'],
            ['description'=>'GraceCenter','link'=>'grace_center/patient_list'],
            ['description'=>'Obstetrics','link'=>'obstetrics/ultrasound_list'],
            ['description'=>'Cashier','link'=>'cashier/admission_list'],
            ['description'=>'Generalist','link'=>'generalist/patient_list'],
            ['description'=>'Dentist','link'=>'dentist/patient_list'],
            ['description'=>'Delivery','link'=>'delivery/registration'],
            ['description'=>'StorkCenter','link'=>'stork/admission'],
        ]);
    }
}
