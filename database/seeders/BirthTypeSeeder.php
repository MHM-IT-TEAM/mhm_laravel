<?php

namespace Database\Seeders;

use App\Models\BirthType;
use Illuminate\Database\Seeder;

class BirthTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BirthType::insert([
            ['name'=>'spontaneous'],
            ['name'=>'Kiwi'],
            ['name'=>'Vaccum'],
            ['name'=>'Forceps'],
            ['name'=>'Fundal pressure'],
            ['name'=>'C-section-primary'],
            ['name'=>'C-section-primary+sterilization'],
            ['name'=>'C-section-secondary-normal'],
            ['name'=>'C-section-secondary-urgent'],
            ['name'=>'C-section-emergency'],
            ['name'=>'Re-C-section-primary'],
            ['name'=>'Re-C-section-secondary-normal'],
            ['name'=>'Re-C-section-secondary-urgent'],
            ['name'=>'Re-C-section-secondary-emergency'],


        ]);
    }
}
