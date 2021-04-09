<?php

namespace App\Http\Controllers\medical\obstetrics;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BabyController extends Controller
{
    public function index(){
        return view('medical.obstetrics.pink.babies.weight_overview');
    }
    public function fetch_data($patId){
        $patient= Patient::find($patId);
        $dob =Carbon::parse($patient->birthDate);
        $datas= $patient->babyCheckups()->get();
        $birth_weight_data= $patient->birth_medical_data()->get(['birth_weight']);
        $birth_weight=0;
        foreach ($birth_weight_data as $bw){
            $birth_weight=$bw['birth_weight'];
        }
        $output=[];
        foreach ($datas as $data){
            $consult_date=  Carbon::parse($data->created_at);
            $output['checkup'][]=[
                'day'=>$dob->diffInDays($consult_date),
                'weight'=>$data->weight,

                //$dob->diffInDays($consult_date)=>$data->weight
            ];
            $output['birth_weight']=$birth_weight;

        }
        return  response()->JSON($output);
    }
}
