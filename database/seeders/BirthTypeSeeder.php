<?php

namespace Database\Seeders;

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
        BirthTypeSeeder::insert([
            ['name'=>'normal'],
            ['name'=>'Kiwi'],
            ['name'=>'forceps'],
            ['name'=>'C-section'],
            ['name'=>'Curretage'],
            ['name'=>'Cytotec']
        ]);
    }
}
