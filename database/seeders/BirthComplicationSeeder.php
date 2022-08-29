<?php

namespace Database\Seeders;

use App\Models\BirthComplication;
use Illuminate\Database\Seeder;

class BirthComplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BirthComplication::insert(
            [
                ['name'=>'Gestational_diabetes','type'=>'before'],
                ['name'=>'Gestational_diabetes','type'=>'before'],
            ]
        );
    }
}
