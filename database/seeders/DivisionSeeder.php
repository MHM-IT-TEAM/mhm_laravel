<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Division::insert([
//            ['name'=>'Out patient','department_id'=>2,'code'=>121],
//            ['name'=>'In patient','department_id'=>2,'code'=>122],
//            ['name'=>'Deliveries','department_id'=>2,'code'=>123],
//            ['name'=>'Surgeries','department_id'=>2,'code'=>124],
//            ['name'=>'Referrals, external medical care','department_id'=>2,'code'=>125],
//            ['name'=>'Medical services','department_id'=>2,'code'=>131],
//            ['name'=>'Tulisa','department_id'=>2,'code'=>132],
//            ['name'=>'Sponsorships','department_id'=>2,'code'=>141],
//        ]);
        Division::insert([
            ['name'=>'Mobile medical','project_id'=>1,'code'=>11],
            ['name'=>'Hospital','project_id'=>1,'code'=>12],
            ['name'=>'Cooperation','project_id'=>1,'code'=>13],
            ['name'=>'Support','project_id'=>1,'code'=>14],
            ['name'=>'Outreach','project_id'=>1,'code'=>15],
            ['name'=>'Training','project_id'=>1,'code'=>16],
            ['name'=>'AAOM','project_id'=>2,'code'=>21],
        ]);

    }
}
