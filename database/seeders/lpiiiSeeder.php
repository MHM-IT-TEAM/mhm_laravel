<?php

namespace Database\Seeders;

use App\Models\lpiii;
use Illuminate\Database\Seeder;

class lpiiiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        lpiii::insert([
            ['name'=>'Head'],
            ['name'=>'Butt'],
            ['name'=>'Small parts'],
            ['name'=>'None'],
        ]);
    }
}
