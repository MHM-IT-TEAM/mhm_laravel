<?php

namespace Database\Seeders;

use App\Models\Bed;
use Illuminate\Database\Seeder;

class BedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bed::insert([
            [
                'code'=>'R1',
                'description'=>'Red N-1',
                'service_id'=>'14',
                'occupied'=>0,
                'room'=>'red',
            ],
            [
                'code'=>'R2',
                'description'=>'Red N-2',
                'service_id'=>'14',
                'occupied'=>1,
                'room'=>'red',
            ],
            [
                'code'=>'y1',
                'description'=>'Yellow N-1',
                'service_id'=>'14',
                'occupied'=>0,
                'room'=>'yellow',
            ],
        ]);
    }
}
