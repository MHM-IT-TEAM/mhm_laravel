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
            ['name'=>'PCGF'],
            ['name'=>'PCGM'],
            ['name'=>'PSGA'],
            ['name'=>'PCDA'],
            ['name'=>'PSDM'],
            ['name'=>'PSDA'],
            ['name'=>'PSDF'],
            ['name'=>'PO'],
            ['name'=>'PCDF'],
            ['name'=>'PCDM'],
            ['name'=>'PCGA'],
            ['name'=>'PCGM'],
            ['name'=>'PT'],
        ]);
    }
}
