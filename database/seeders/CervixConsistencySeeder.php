<?php

namespace Database\Seeders;


use App\Models\CervixConsistency;
use Illuminate\Database\Seeder;

class CervixConsistencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CervixConsistency::insert([
            ['name'=>'soft'],
            ['name'=>'tough'],
            ['name'=>'oedematus'],
        ]);
    }
}
