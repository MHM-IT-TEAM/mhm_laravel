<?php


namespace App\Service\Medical\obstetrics;

use App\Models\Admission;
use App\Models\CpnFollowup;
use Illuminate\Database\Eloquent\Model;

class CpnFollowupService
{
 public function store($request){
    CpnFollowup::create($this->fill_data($request));

//    if ($request->admission_id) {
//        $admission = Admission::find($request->admission_id);
//        if ($admission) {
//            $admission->status = 'DONE';
//            $admission->save();
//        }
//    }
    return ['success'=>true];
 }
 private function fill_data($request){
    $seniors="";
    if(count($request->senior_informed)>0){
        foreach($request->senior_informed as $senior){
            $seniors .= $senior . ",";
        }
        $seniors = rtrim($seniors,',');
    }
     return [
         'cpn_admission_id'=>intval($request->cpn_admission_id),
         'gestational_age'=>$request->gestational_age,
         'weight'=>$request->weight,
         'bp_left'=>$request->bp_left,
         'bp_right'=>$request->bp_right,
         'eyes'=>$request->eyes,
         'breast'=>$request->breast,
         'belly_size'=>$request->belly_size,
         'uterus_size'=>$request->uterus_size,
         'lp1'=>$request->lp1,
         'lp2'=>$request->lp2,
         'lp3'=>$request->lp3,
         'mov_baby'=>$request->mov_baby,
         'heartbeat_baby'=>$request->heartbeat_baby,
         'cervix_length'=>$request->cervix_length,
         'cervix_position'=>$request->cervix_position,
         'cervix_consistency'=>$request->cervix_consistency,
         'cervix_opening'=>$request->cervix_opening,
         'discharge'=>$request->discharge,
         'liquids'=>$request->liquids,
         'oedema'=>$request->oedema,
         'varicosis'=>$request->varicosis,
         'protein_test'=>$request->protein_test,
         'sugar_test'=>$request->sugar_test,
         'blood_test'=>$request->blood_test,
         'leucocyte_test'=>$request->leucocyte_test,
         'ogtt'=>$request->ogtt,
         'membranes'=>$request->membranes,
         'leading_part'=>$request->leading_part,
         'leading_part_attitude'=>$request->leading_part_attitude,
         'us_needed'=>$request->us_needed,
         'us_reason'=>$request->us_reason,
         'us_explanation'=>$request->us_explanation,
         'ctg_needed'=>$request->ctg_needed,
         'ctg_reason'=>$request->ctg_reason,
         'ctg_explanation'=>$request->ctg_explanation,
         'appointment'=>$request->appointment,
         'responsible'=>$request->responsible,
         'senior_informed'=>$seniors,
         'remark'=>$request->remark
     ];
 }
 public function update($request,$id){
    $followup= CpnFollowup::find($id);
    $followup->fill($this->fill_data($request))->save();
     return ['success'=>true];
 }
 public function delete($id){
     CpnFollowup::find($id)->delete();
 }
}
