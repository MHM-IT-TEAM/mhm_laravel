<?php


namespace App\Service\Medical\obstetrics;


use App\Models\CpnFollowup;

class CpnFollowupService
{
 public function store($request){
    $cpn= new CpnFollowup();
    $cpn->create($this->fill_data($request));
    return ['success'=>true];
 }
 private function fill_data($request){
     return [
         'cpn_admission_id'=>$request->cpn_admission_id,
         'week_of_pregnancy'=>$request->week_of_pregnancy,
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
         'cervix_opening'=>$request->cervix_opening,
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
         'ctg_needed'=>$request->ctg_needed,
         'appointment'=>$request->appointment,
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
