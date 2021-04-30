<?php

namespace Database\Seeders;

use App\Models\PresentationOfBaby;
use Illuminate\Database\Seeder;

class PresentationOfBabySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PresentationOfBaby::insert([
            ['name'=>'Cephalic'],
            ['name'=>'Breech'],
            ['name'=>'Oblique'],
            ['name'=>'Transversal'],

        ]);
    }
}
