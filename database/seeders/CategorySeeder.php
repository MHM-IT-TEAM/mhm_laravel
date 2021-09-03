<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['name'=>'ULM','division_id'=>1,'code'=>111,'joyCenter'=>0],
            ['name'=>'MidMob','division_id'=>1,'code'=>112,'joyCenter'=>0],
            ['name'=>'DentMob','division_id'=>1,'code'=>113,'joyCenter'=>0],
            ['name'=>'Ambulance','division_id'=>1,'code'=>114,'joyCenter'=>0],
            ['name'=>'Outreaches with partners','division_id'=>1,'code'=>115,'joyCenter'=>0],
            ['name'=>'Outpatient','division_id'=>2,'code'=>121,'joyCenter'=>1],
            ['name'=>'Inpatient','division_id'=>2,'code'=>122,'joyCenter'=>1],
            ['name'=>'Delivery','division_id'=>2,'code'=>123,'joyCenter'=>1],
            ['name'=>'Surgery','division_id'=>2,'code'=>124,'joyCenter'=>1],
            ['name'=>'Referral','division_id'=>2,'code'=>125,'joyCenter'=>0],
            ['name'=>'Hospital in general','division_id'=>2,'code'=>126,'joyCenter'=>0],
            ['name'=>'Medical Service','division_id'=>3,'code'=>131,'joyCenter'=>1],
            ['name'=>'Tulisa','division_id'=>3,'code'=>132,'joyCenter'=>0],
            ['name'=>'Sponsorship','division_id'=>4,'code'=>141,'joyCenter'=>1],
            ['name'=>'Social affairs/Ministry','division_id'=>5,'code'=>151,'joyCenter'=>0],
            ['name'=>'Internal','division_id'=>6,'code'=>161,'joyCenter'=>0],
            ['name'=>'External','division_id'=>6,'code'=>162,'joyCenter'=>0],

        ]);
    }
}
