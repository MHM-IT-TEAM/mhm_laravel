<?php

namespace App\Http\Controllers\V1\patient_system\delivery;

use App\Http\Controllers\Controller;
use App\Models\Birth;
use App\Models\BirthAdminData;
use App\Models\CpnAdmission;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BirthRegistrationController extends Controller
{

    public function book()
    {
        return Birth::deliveryBook();
    }

    public function create()
    {
        //
    }


    public function register_birth(Request $request)
    {
       //register the birth main data
        return Birth::createBirth($request);
    }


    public function show($id)
    {

        return Birth::with(['BirthAdminData','patient','birthMedicalDataBabies','birthMedicalDataMoms'])->where('code',$id)->first();
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function birth_certificate(Request $request, $id){
        BirthAdminData::find($id)->update($request->except(['code','birth_date','birth_time','mom_id','baby_id']));
        //update the mom in patient table
        $mom= Patient::find($request->mom_id);
        $mom->firstName=$request->mom_firstName;
        $mom->lastName=$request->mom_lastName;
        $mom->adress=$request->mom_address;
        $mom->job=$request->mom_job;
        $mom->save();
       // update the baby in the patient table
        $baby= Patient::find($request->baby_id);
        $baby->firstName=$request->baby_firstName;
        $baby->lastName=$request->baby_lastName;
        $baby->adress=$request->mom_address;
        $baby->save();
        return response()->json(['success'=>true]);
    }
    public function last_birth_code(){
        $birth=Birth::latest()->first();
        if($birth)return $birth->code;
        else return date("Y").'-000';
    }
    public function fetch_patient_data($id){
        $patient=Patient::with(['cpnAdmissions'=>function($data){
            return $data->latest('created_at')->get();
        }])
            ->with(['ultraSoundAdmissions'=>function($data){
                return $data->latest('created_at')->first();
            }])
            ->find($id);
        $ga='';
//        dd($patient->cpnAdmissions);
        //return the last Gestational age
        if(count($patient->cpnAdmissions)>0){
            $ref=$patient->cpnAdmissions[0]["id"];
            $admission= CpnAdmission::with(['followups'=>function($data){
                return $data->latest('created_at')->first();
            }])->find($ref);
            $ga= $admission->followups[0]["gestational_age"];//28+2
            if($ga !==""){
                $ga_date= $admission->followups[0]["created_at"];//2021/07/14
                $diff_in_days=Carbon::now()->floatDiffInWeeks(Carbon::parse($ga_date));
                $int_value=floor($diff_in_days);//1
                $decimal= (($diff_in_days-$int_value)*6); // question: why is this *6 ? 5.4
                $split= explode('+',$ga);//28,2
                $ga=$this->calculate($int_value,$split[0],$decimal,$split[1]);
            }

        }

        return response()->json([
            "ga"=>$ga,
            "patient_data"=>$patient
        ]);
    }
    private function calculate($whole,$whole1,$part0,$part1){
        $part= $whole+$whole1;//1+28=29
        $dec=$part0+$part1;//5.4+2=7.4
        if($dec>6){
            $part=$part+1;//30
            $dec=round($dec/6);
        };
        return $part."+".round($dec);
    }
}
