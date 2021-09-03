<?php

namespace Database\Seeders;

use App\Models\PatientCategory;
use Illuminate\Database\Seeder;

class PatientCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return PatientCategory::insert([
            ['name'=>'Sector'],
            ['name'=>'Out sector'],
            ['name'=>'Staff'],
            ['name'=>'Staff family'],
            ['name'=>'Partners'],
            ['name'=>'VIP'],
        ]);
    }
}
