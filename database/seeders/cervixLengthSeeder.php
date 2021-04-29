<?php

namespace Database\Seeders;

use App\Models\CervixLength;
use Illuminate\Database\Seeder;

class cervixLengthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CervixLength::insert([
            ['name'=>'long'],
            ['name'=>'half long'],
            ['name'=>'short'],
            ['name'=>'effaced'],
        ]);
    }
}
