<?php

namespace App\Http\Controllers\V1\admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\DentalTreatment;
use App\Models\StorkAction;
use App\Models\StorkAdmission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function statistics_overview(){

        return response()->json([
            "ulm"=>[],
            "midMob"=>[],
            "dentMob"=>[],
            "ambulance"=>[],
            "outreaches"=>[],
            "general_consultation"=>$this->_populate(Admission::class,6),
            "general_vaccination"=>$this->_populate(Admission::class,7),
            "general_injury"=>$this->_populate(Admission::class,8),
            "dental_consultation"=>$this->_populate(Admission::class,9),
            "dental_extraction"=>self::_dental_treatments('extraction'),
            "dental_care"=>self::_dental_treatments('care'),
            "dental_cleaning"=>self::_dental_cleaning(),
            "obstetrical_ultrasound"=>$this->_populate(Admission::class,11),
            "obstetrical_first_cpn"=>$this->_populate(Admission::class,12),
            "obstetrical_cpn_followup"=>$this->_populate(Admission::class,13),
            "postpartum_baby"=>$this->_populate(Admission::class,14),
            "postpartum_mom"=>$this->_populate(Admission::class,15),
            "postpartum_meeting"=>$this->_populate(Admission::class,16),
            "pediatric_vaccination"=>$this->_populate(Admission::class,17),
            "pediatric_checkup"=>$this->_populate(Admission::class,18),
            "pediatric_sickness"=>$this->_populate(Admission::class,19),
            "pediatric_injury"=>$this->_populate(Admission::class,20),
            "dermatological"=>$this->_populate(Admission::class,21),
            "in_patient_general"=>$this->_populate(Admission::class,23),
            "in_patient_dental"=>$this->_populate(Admission::class,24),
            "in_patient_obstetrical"=>$this->_populate(Admission::class,25),
            "in_patient_obstetrical_action"=>$this->_count_actions(25),
            "in_patient_pediatric"=>$this->_populate(Admission::class,26),
            "in_patient_pediatric_action"=>$this->_count_actions(26),
            "in_patient_dermatological"=>$this->_populate(Admission::class,27),
            "inpatient_other"=>[],
            "deliveries"=>[],
            "surgery_general"=>[],
            "surgery_obstetrical"=>[],
            "surgery_pediatric"=>[],
            "surgery_other"=>[],
        ]);
    }
    private function _count_actions($service_activity){
        $pre_list=[];
        $result=[];
        $actions= Admission::where('service_activity_id',$service_activity)->with('storkAdmission.stork_actions')->get()->pluck('storkAdmission.stork_actions');
        foreach($actions as $act){
          if(isset($act) && count($act)>0 ){
              foreach($act as $value){
                  $pre_list[]=intval(Carbon::parse($value['created_at'])->format('m'));
              }
          }
        }
        $output= array_count_values($pre_list);
        for($i=0; $i<12;$i++){

            if (!array_key_exists($i+1,$output))
            {
                $result[] = 0;
            }else{
                $result[]=$output[$i+1];
            }
        }
        return $result;
    }
    private function _populate($class,$service_activity_id){
        $output=[];
        for($i=0; $i<12;$i++){
            $output[]=$class::whereMonth('created_at',$i+1)
                ->where('service_activity_id',$service_activity_id)
                ->where('payment_status','PAID')
                ->get()->count();
        }
        return $output;
    }
    private static function _dental_treatments($treatment_type){
        $output=[];
        for($i=0; $i<12;$i++){
            $treatment= DentalTreatment::whereMonth('created_at',$i+1)->where($treatment_type,'<>',"")->pluck($treatment_type);
            $count=0;
            foreach($treatment as $treat){
                $count+= count(explode("-",$treat));
            }
            $output[]=$count;
        }
        return $output;
    }
    private static function _dental_cleaning(){
        $output=[];
        for($i=0; $i<12;$i++){
            $output[]= DentalTreatment::whereMonth('created_at',$i+1)->where('cleaning_necessary','<>',"")->get()->count();
        }
        return $output;
    }
}
