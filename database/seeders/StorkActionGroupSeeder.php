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
                'description'=>'Assistance Pee',
                'category'=>'adult',
                'type'=>'mobilisation'
            ],
            [
                'description'=>'Assistance Caca',
                'category'=>'adult',
                'type'=>'mobilisation'
            ],
            [
                'description'=>'Assistance Eating',
                'category'=>'adult',
                'type'=>'mobilisation'
            ],
            [
                'description'=>'Assistance Sleeping',
                'category'=>'adult',
                'type'=>'mobilisation'
            ],
            [
                'description'=>'Catheter out',
                'category'=>'adult',
                'type'=>'mobilisation'
            ],
            [
                'description'=>'First mobilisation',
                'category'=>'adult',
                'type'=>'mobilisation'
            ],

            [
                'description'=>'Washing',
                'category'=>'adult',
                'type'=>'body_care'
            ],
            [
                'description'=>'Shower',
                'category'=>'adult',
                'type'=>'body_care'
            ],
            [
                'description'=>'Shaving',
                'category'=>'adult',
                'type'=>'body_care'
            ],
            [
                'description'=>'Breast massage',
                'category'=>'adult',
                'type'=>'breast_care'
            ],
            [
                'description'=>'Breast pumping',
                'category'=>'adult',
                'type'=>'breast_care'
            ],
            [
                'description'=>'Urinary sonde In',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Urinary sonde OUT',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Catheter IN',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Catheter OUT',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Drainage',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Glycemia test',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'TV',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Weighting maternity pads',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Maternity pads In',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Maternity pads Out',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Belly Size',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'IV ON',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'IV Out',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Stiches',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Begin OGTT',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'OGTT Result',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Uterus size',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Ballon catheter in',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Ballon catheter out',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Drainage In',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Drainage Out',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Weight before',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Weight after',
                'category'=>'adult',
                'type'=>'medical_care'
            ],


            [
                'description'=>'Breast feeding',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Breast pumping',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Breast check',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Breast massage',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Blood sugar test',
                'category'=>'adult',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Check bleeding',
                'category'=>'both',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Take weight',
                'category'=>'both',
                'type'=>'medical_care'
            ],
            //baby
            [
                'description'=>'Add milk',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'bottle feeding',
                'category'=>'baby',
                'type'=>'medical_care'
            ],

            [
                'description'=>'feed sonde',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Finger feeding',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'breast feed with set',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Bilibed On',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Bilibed Off',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Phototherapy On',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Phototherapy Off',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Weight before',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Weight after',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Milk drunk',
                'category'=>'baby',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Gain weight',
                'category'=>'both',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Loose weight',
                'category'=>'both',
                'type'=>'medical_care'
            ],
            [
                'description'=>'Bilirubin test',
                'category'=>'baby',
                'type'=>'medical_care'
            ],

        ]);
    }
}
