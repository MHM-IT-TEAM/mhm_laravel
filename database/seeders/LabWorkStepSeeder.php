<?php

namespace Database\Seeders;

use App\Models\LabWorkStep;
use Illuminate\Database\Seeder;

class LabWorkStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LabWorkStep::insert([
            ['code'=>'RO','description'=>'request opened'],
            ['code'=>'P','description'=>'processing'],
            ['code'=>'RA','description'=>'result avalaible'],
            ['code'=>'W','description'=>'Waiting'],
        ]);
    }
}
