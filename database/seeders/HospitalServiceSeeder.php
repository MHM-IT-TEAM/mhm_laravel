<?php

namespace Database\Seeders;

use App\Models\HospitalService;
use Illuminate\Database\Seeder;

class HospitalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HospitalService::insert([
            ['name'=>'Stork'],
            ['name'=>'Pediatry'],
            ['name'=>'Block']
        ]);
    }
}
