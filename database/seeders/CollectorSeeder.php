<?php

namespace Database\Seeders;

use App\Models\inventory_system\Collector;
use Illuminate\Database\Seeder;

class CollectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Collector::insert([
            ['name'=>'Vahatra','department_id'=>1,'orderer_id'=>1],
            ['name'=>'Ando','department_id'=>2,'orderer_id'=>2],
            ['name'=>'Hobilalaina','department_id'=>2,'orderer_id'=>2],
            ['name'=>'Mampionona','department_id'=>2,'orderer_id'=>2],
            ['name'=>'Tianasoa','department_id'=>4,'orderer_id'=>4],
            ['name'=>'Tiavina','department_id'=>6,'orderer_id'=>6],
            ['name'=>'Hianja','department_id'=>6,'orderer_id'=>6],
            ['name'=>'Hasina','department_id'=>6,'orderer_id'=>6],
            ['name'=>'Lanto','department_id'=>11,'orderer_id'=>11],
            ['name'=>'Dr Norosoa','department_id'=>8,'orderer_id'=>8],

        ]);
    }
}
