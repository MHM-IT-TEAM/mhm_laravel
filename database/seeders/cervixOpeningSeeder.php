<?php

namespace Database\Seeders;

use App\Models\CervixOpening;
use Illuminate\Database\Seeder;

class cervixOpeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CervixOpening::insert([
            ['name'=>'1cm'],
            ['name'=>'2cm'],
            ['name'=>'3cm'],
            ['name'=>'4cm'],
            ['name'=>'5cm'],
            ['name'=>'closed'],
        ]);
    }
}
