<?php

namespace Database\Seeders;

use App\Models\Senior;
use Illuminate\Database\Seeder;

class SeniorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Senior::insert([
            ['name'=>'Tanja Hock','medical_team'=>true],
            ['name'=>'Tianasoa Lancia','medical_team'=>true],
            ['name'=>'Marlys','medical_team'=>true],
        ]);
    }
}
