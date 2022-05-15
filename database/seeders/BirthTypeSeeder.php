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
            ['name'=>'C-section-primary'],
            ['name'=>'C-section-secondary'],
            ['name'=>'C-section-urgent'],
            ['name'=>'C-section-emergency'],

        ]);
    }
}
