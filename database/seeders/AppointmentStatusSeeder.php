<?php

namespace Database\Seeders;

use App\Models\AppointmentStatu;
use Illuminate\Database\Seeder;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppointmentStatu::insert([
            ['name' => 'booked'],
            ['name' => 'Came'],
            ['name' => 'did not come'],
            ['name' => 'cancelled'],
            ['name' => 'postponed'],
        ]);
    }
}
