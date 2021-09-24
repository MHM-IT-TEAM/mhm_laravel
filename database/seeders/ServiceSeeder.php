<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert([
            ['name'=>'ULM','category_id'=>1,'code'=>11100,'joyCenter'=>0],
            ['name'=>'MidMob','category_id'=>2,'code'=>11200,'joyCenter'=>0],
            ['name'=>'DentMob','category_id'=>3,'code'=>11300,'joyCenter'=>0],
            ['name'=>'Ambulance car','category_id'=>4,'code'=>11400,'joyCenter'=>0],
            ['name'=>'Outreaches with partners','category_id'=>5,'code'=>11500,'joyCenter'=>0],
            ['name'=>'General','category_id'=>6,'code'=>12101,'joyCenter'=>1],
            ['name'=>'Dental','category_id'=>6,'code'=>12102,'joyCenter'=>1],
            ['name'=>'Obstetrical','category_id'=>6,'code'=>12103,'joyCenter'=>1],
            ['name'=>'Pediatric','category_id'=>6,'code'=>12104,'joyCenter'=>1],
            ['name'=>'Dermatological','category_id'=>6,'code'=>12105,'joyCenter'=>1],
            ['name'=>'Other','category_id'=>6,'code'=>12106,'joyCenter'=>1],
            ['name'=>'General','category_id'=>7,'code'=>12201,'joyCenter'=>1],
            ['name'=>'Dental','category_id'=>7,'code'=>12202,'joyCenter'=>1],
            ['name'=>'Obstetrical','category_id'=>7,'code'=>12203,'joyCenter'=>1],
            ['name'=>'Pediatric','category_id'=>7,'code'=>12204,'joyCenter'=>1],
            ['name'=>'Dermatological','category_id'=>7,'code'=>12205,'joyCenter'=>1],
            ['name'=>'Other','category_id'=>7,'code'=>12206,'joyCenter'=>1],
            ['name'=>'Obstetrical','category_id'=>8,'code'=>12301,'joyCenter'=>1],
            ['name'=>'General','category_id'=>9,'code'=>12401,'joyCenter'=>1],
            ['name'=>'Dental','category_id'=>9,'code'=>12402,'joyCenter'=>1],
            ['name'=>'Obstetrical','category_id'=>9,'code'=>12403,'joyCenter'=>1],
            ['name'=>'Pediatric','category_id'=>9,'code'=>12404,'joyCenter'=>1],
            ['name'=>'Dermatological','category_id'=>9,'code'=>12405,'joyCenter'=>1],
            ['name'=>'Other','category_id'=>9,'code'=>12406,'joyCenter'=>1],
            ['name'=>'General','category_id'=>10,'code'=>12501,'joyCenter'=>1],
            ['name'=>'Dental','category_id'=>10,'code'=>12502,'joyCenter'=>1],
            ['name'=>'Obstetrical','category_id'=>10,'code'=>12503,'joyCenter'=>1],
            ['name'=>'Pediatric','category_id'=>10,'code'=>12504,'joyCenter'=>1],
            ['name'=>'Dermatological','category_id'=>10,'code'=>12505,'joyCenter'=>1],
            ['name'=>'Other','category_id'=>10,'code'=>12506,'joyCenter'=>1],
            ['name'=>'Hospital in general','category_id'=>11,'code'=>12600,'joyCenter'=>1],
            ['name'=>'Dermatological','category_id'=>12,'code'=>13101,'joyCenter'=>1],
            ['name'=>'Ophthalmology','category_id'=>12,'code'=>13102,'joyCenter'=>1],
            ['name'=>'German doctors','category_id'=>12,'code'=>13103,'joyCenter'=>1],
            ['name'=>'O-therapy','category_id'=>12,'code'=>13104,'joyCenter'=>1],
            ['name'=>'Other','category_id'=>12,'code'=>13105,'joyCenter'=>1],
            ['name'=>'General','category_id'=>13,'code'=>13201,'joyCenter'=>1],
            ['name'=>'Dental','category_id'=>13,'code'=>13202,'joyCenter'=>1],
            ['name'=>'Obstetrical','category_id'=>13,'code'=>13203,'joyCenter'=>1],
            ['name'=>'Pediatric','category_id'=>13,'code'=>13204,'joyCenter'=>1],
            ['name'=>'Dermatological','category_id'=>13,'code'=>13205,'joyCenter'=>1],
            ['name'=>'Other','category_id'=>13,'code'=>13206,'joyCenter'=>1],
            ['name'=>'Medical support','category_id'=>14,'code'=>14101,'joyCenter'=>0],
            ['name'=>'Families','category_id'=>14,'code'=>14102,'joyCenter'=>0],
            ['name'=>'MHM Staff Families','category_id'=>14,'code'=>14103,'joyCenter'=>0],
            ['name'=>'Kids','category_id'=>14,'code'=>14104,'joyCenter'=>0],
            ['name'=>'MHM Staff Kids','category_id'=>14,'code'=>14105,'joyCenter'=>0],
            ['name'=>'Milk Program','category_id'=>14,'code'=>14106,'joyCenter'=>1],
            ['name'=>'Pregnancies','category_id'=>14,'code'=>14107,'joyCenter'=>1],
            ['name'=>'Chaplaincy','category_id'=>15,'code'=>15101,'joyCenter'=>1],
            ['name'=>'Kids club','category_id'=>15,'code'=>15102,'joyCenter'=>1],
            ['name'=>'Play mobile','category_id'=>15,'code'=>15103,'joyCenter'=>1],
            ['name'=>'Prayer worship Alpha course','category_id'=>15,'code'=>15104,'joyCenter'=>1],
            ['name'=>'Sensibilization','category_id'=>15,'code'=>15105,'joyCenter'=>1],
            ['name'=>'Admin','category_id'=>16,'code'=>16101,'joyCenter'=>1],
            ['name'=>'Medical','category_id'=>16,'code'=>16102,'joyCenter'=>1],
            ['name'=>'Social','category_id'=>16,'code'=>16103,'joyCenter'=>1],
            ['name'=>'Technical','category_id'=>16,'code'=>16104,'joyCenter'=>1],
            ['name'=>'Admin','category_id'=>17,'code'=>16201,'joyCenter'=>1],
            ['name'=>'Medical','category_id'=>17,'code'=>16202,'joyCenter'=>1],
            ['name'=>'Social','category_id'=>17,'code'=>16203,'joyCenter'=>1],
            ['name'=>'Technical','category_id'=>17,'code'=>16204,'joyCenter'=>1],



        ]);
    }
}
