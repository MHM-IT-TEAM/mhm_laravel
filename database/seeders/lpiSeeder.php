<?php

namespace Database\Seeders;

use App\Models\lpi;
use Illuminate\Database\Seeder;

class lpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        lpi::insert([
            ['name'=>'Sup S'],
            ['name'=>'S'],
            ['name'=>'S+1'],
            ['name'=>'S+2'],
            ['name'=>'S+3'],
            ['name'=>'S/U'],
            ['name'=>'U-3'],
            ['name'=>'U-2'],
            ['name'=>'U-1'],
            ['name'=>'U'],
            ['name'=>'U+1'],
            ['name'=>'U+2'],
            ['name'=>'U+3'],
            ['name'=>'U+4'],
            ['name'=>'U/C'],
            ['name'=>'C/U'],
            ['name'=>'C-3'],
            ['name'=>'C-2'],
            ['name'=>'C-1'],
            ['name'=>'C'],

        ]);
    }
}
