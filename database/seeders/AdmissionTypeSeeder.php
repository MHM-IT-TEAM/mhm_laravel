<?php

namespace Database\Seeders;

use App\Models\AdmissionType;
use Illuminate\Database\Seeder;

class AdmissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdmissionType::insert([
            ['code'=>'A','description'=>'simple admission'],
            ['code'=>'IR','description'=>'internal referral'],
            ['code'=>'AC','description'=>'additional consultation']
        ]);
    }
}
