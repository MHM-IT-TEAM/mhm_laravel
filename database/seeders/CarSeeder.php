<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Car::insert([
            ['name'=>'Ambulance'],
            ['name'=>'Isuzu Blue'],
            ['name'=>'Isuzu Green'],
            ['name'=>'Galopper'],
            ['name'=>'Sprinter'],
            ['name'=>'Starex'],
        ]);
    }
}
