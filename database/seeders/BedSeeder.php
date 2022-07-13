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
                'code'=>'R3',
                'description'=>'Red N-3',
                'service_id'=>'14',
                'occupied'=>1,
                'room'=>'red',
            ],
            [
                'code'=>'R4',
                'description'=>'Red N-4',
                'service_id'=>'14',
                'occupied'=>1,
                'room'=>'red',
            ],
            [
                'code'=>'Y1',
                'description'=>'Yellow N-1',
                'service_id'=>'14',
                'occupied'=>0,
                'room'=>'yellow',
            ],
            [
                'code'=>'Y2',
                'description'=>'Yellow N-2',
                'service_id'=>'14',
                'occupied'=>0,
                'room'=>'yellow',
            ],
            [
                'code'=>'Y3',
                'description'=>'Yellow N-3',
                'service_id'=>'14',
                'occupied'=>0,
                'room'=>'yellow',
            ],
            [
                'code'=>'Y4',
                'description'=>'Yellow N-4',
                'service_id'=>'14',
                'occupied'=>0,
                'room'=>'yellow',
            ],
            [
                'code'=>'REC-1',
                'description'=>'Recovery 1',
                'service_id'=>'14',
                'occupied'=>0,
                'room'=>'recovery',
            ],
            [
                'code'=>'REC-2',
                'description'=>'Recovery 2',
                'service_id'=>'14',
                'occupied'=>0,
                'room'=>'recovery',
            ],
        ]);
    }
}
