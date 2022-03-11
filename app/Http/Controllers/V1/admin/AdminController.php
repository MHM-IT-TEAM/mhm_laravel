<?php

namespace App\Http\Controllers\V1\admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\DentalTreatment;
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
            "pediatric_injury"=>[],
            "dermatological"=>[],
            "inpatient_general"=>[],
            "inpatient_dental"=>[],
            "inpatient_obstetrical"=>[],
            "inpatient_pediatric"=>[],
            "inpatient_dermatological"=>[],
            "inpatient_other"=>[],
            "deliveries"=>[],
            "surgery_general"=>[],
            "surgery_obstetrical"=>[],
            "surgery_pediatric"=>[],
            "surgery_other"=>[],
        ]);
    }
    private function _populate($class,$service_activity_id){
        $output=[];
        for($i=0; $i<12;$i++){
            $output[]=$class::whereMonth('created_at',$i+1)->where('service_activity_id',$service_activity_id)->get()->count();
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
