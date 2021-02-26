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
            ]
        ]);
    }
}
