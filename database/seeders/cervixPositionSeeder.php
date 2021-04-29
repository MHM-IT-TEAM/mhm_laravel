<?php

namespace Database\Seeders;

use App\Models\CervixPosition;
use Illuminate\Database\Seeder;

class cervixPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CervixPosition::insert([
            ['name'=>'Sacral'],
            ['name'=>'Mediosacral'],
            ['name'=>'Central'],
        ]);
    }
}
