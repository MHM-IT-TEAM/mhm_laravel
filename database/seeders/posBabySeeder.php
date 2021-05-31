<?php

namespace Database\Seeders;

use App\Models\PositionOfBaby;
use Illuminate\Database\Seeder;

class posBabySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PositionOfBaby::insert([
            ['name'=>'left'],
            ['name'=>'right'],
            ['name'=>'anterior'],
            ['name'=>'posterior'],
            ['name'=>'up'],
            ['name'=>'down'],
        ]);
    }
}
