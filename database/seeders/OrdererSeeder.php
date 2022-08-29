<?php

namespace Database\Seeders;

use App\Models\inventory_system\Orderer;
use Illuminate\Database\Seeder;

class OrdererSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Orderer::insert([
            ['name'=>'graceCenter'],
            ['name'=>'stork'],
            ['name'=>'bloc'],
            ['name'=>'midPink'],
            ['name'=>'pediatric'],
            ['name'=>'anesthetist'],
            ['name'=>'ambulance'],
            ['name'=>'glDoctor'],
            ['name'=>'dentDoctor'],
            ['name'=>'midMob'],
            ['name'=>'dentMob'],
            ['name'=>'glMob'],
            ['name'=>'office'],
            ['name'=>'houseHold'],
            ['name'=>'joyCenter'],
            ['name'=>'technical'],
            /**
             * grace
             * joycenter
             * doctor
             * dentist
             *sterilisation
             * yuckyroom
             * ultrasound
             * pinkroom_midwives
             * unclean_room
             * anesthetist for bloc
             * nurse for bloc
             * anesthetist for ambulance
             * anesthetist for stork center
             * anesthettist for anesthesia
             * midwives for delivery room
             * pediatric intensive care
             * pediatric infectious care
             * dentMob
             * MidMob
             *
            **/
        ]);
    }
}
