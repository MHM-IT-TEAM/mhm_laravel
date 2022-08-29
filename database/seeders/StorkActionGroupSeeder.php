<?php

namespace Database\Seeders;

use App\Models\StorkActionGroup;
use Illuminate\Database\Seeder;

class StorkActionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StorkActionGroup::insert([
            [
                'description'=>'Assistance Urine',
                'type'=>'mobilisation'
            ],
            [
                'description'=>'Assistance Caca',
                'type'=>'mobilisation'
            ],
            [
                'description'=>'Assistance Eating',
                'type'=>'mobilisation'
            ],
            [
                'description'=>'Assistance Sleeping',
                'type'=>'mobilisation'
            ],
//            [
//                'description'=>'External manoeuver',
//                'type'=>'mobilisation'
//            ],
            [
                'description'=>'Washing',
                'type'=>'body_care'
            ],
            [
                'description'=>'Shower',
                'type'=>'body_care'
            ],

//            [
//                'description'=>'Blood transfusion',
//                'type'=>'body_care'
//            ],
            [
                'description'=>'Breast massage',
                'type'=>'breast_care'
            ],
            [
                'description'=>'Breast pumping',
                'type'=>'breast_care'
            ],
            [
                'description'=>'Urinary sonde In',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Urinary sonde OUT',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Catheter IN',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Catheter OUT',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Drainage',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Glycemia test',
                'type'=>'medical_care'
            ],
            [
                'description'=>'TV',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Weighting maternity pads',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Maternity pads In',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Maternity pads Out',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Belly Size',
                'type'=>'medical_care'
            ],
            [
                'description'=>'IV ON',
                'type'=>'medical_care'
            ],
            [
                'description'=>'IV Out',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Stiches',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Begin OGTT',
                'type'=>'medical_care'
            ],
            [
                'description'=>'OGTT Result',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Uterus size',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Ballon catheter in',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Ballon catheter out',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Drainage In',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Drainage Out',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Weight before',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Weight after',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Milk drunk',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Add milk',
                'type'=>'medical_care'
            ],


        ]);
    }
}
