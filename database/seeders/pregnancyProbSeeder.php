<?php

namespace Database\Seeders;

use App\Models\PregnancyProblems;
use Illuminate\Database\Seeder;

class pregnancyProbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PregnancyProblems::insert([
            ['name'=>'EUG'],
            ['name'=>'PIH'],
            ['name'=>'PHT'],
            ['name'=>'Preeclampisa/HELLP'],
            ['name'=>'Premature rupture of membrane'],
            ['name'=>'Threatening premature'],
            ['name'=>'Obstetrical infection'],
            ['name'=>'AIS'],
            ['name'=>'Placenta praevia'],
            ['name'=>'IUGR'],
            ['name'=>'Olygohydramnion'],
            ['name'=>'polyhydramnion'],
            ['name'=>'Child malformation'],
            ['name'=>'IUD (MFIU)'],
            ['name'=>'Prolaps'],
            ['name'=>'bleeding'],
        ]);
    }
}
