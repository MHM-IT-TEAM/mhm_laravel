<?php

namespace Database\Seeders;

use App\Models\AnaesthetistConsultation;
use Illuminate\Database\Seeder;

class AnaesthetistConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnaesthetistConsultation::insert([
            ['name'=>'VPA'],
            ['name'=>'Blood work'],
            ['name'=>'Auscultation'],
            ['name'=>'Outpatient anesthesia'],
            ['name'=>'IV'],
            ['name'=>'Resuscitation'],
            ['name'=>'Emergency circulation'],
        ]);
    }
}
