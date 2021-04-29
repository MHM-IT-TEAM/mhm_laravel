<?php

namespace Database\Seeders;

use App\Models\BloodGroup;
use Illuminate\Database\Seeder;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BloodGroup::insert([
            ["name"=>'A'],
            ["name"=>'B'],
            ["name"=>'O'],
            ["name"=>'AB'],
        ]);
    }
}
