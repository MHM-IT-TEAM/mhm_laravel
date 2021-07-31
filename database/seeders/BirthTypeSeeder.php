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
            ['name'=>'vaginally'],
            ['name'=>'Kiwi'],
            ['name'=>'forceps'],
            ['name'=>'C-section'],
            ['name'=>'Curretage'],
            ['name'=>'Cytotec']
        ]);
    }
}
