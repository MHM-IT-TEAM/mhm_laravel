<?php

namespace Database\Seeders;

use App\Models\AdmissionPriority;
use Illuminate\Database\Seeder;

class AdmissionPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdmissionPriority::insert([
            ['code'=>'A','description'=>'VIP, partners, mhm staff and family'],
            ['code'=>'B','description'=>'Special Patient (RR check, premature baby, baby on special schedule)'],
            ['code'=>'C','description'=>'EMERGENCY'],
            ['code'=>'D','description'=>'URGENT'],
            ['code'=>'E','description'=>'Normal'],
        ]);
    }
}
