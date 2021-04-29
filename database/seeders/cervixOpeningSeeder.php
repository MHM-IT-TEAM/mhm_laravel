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
            ['name'=>'tough'],
            ['name'=>'soft'],
        ]);
    }
}
