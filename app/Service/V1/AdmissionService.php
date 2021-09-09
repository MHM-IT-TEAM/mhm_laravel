<?php


namespace App\Service\V1;


use App\Http\Requests\V1\AdmissionRequest;
use App\Models\Admission;
use App\Models\AdmissionCareDetail;
use Illuminate\Http\Request;
use App\Service\V1\Traits\ServiceResponseTrait;


class AdmissionService
{
    use ServiceResponseTrait;

    public function store($request){
        $admission= Admission::create($this->_fill_admission_data($request));
        $this->_fill_care_details($request,$admission->id);

        return $this->success('Admission saved');
    }
    public function update($request,$id){
        //delete care_details
        AdmissionCareDetail::where('admission_id',$id)->delete();
        // update the admission table
        $admission = Admission::find($id);
        $admission->fill($this->_fill_admission_data($request))->save();
        $this->_fill_care_details($request,$id);
        return $this->success('Admission updated');
    }

    public function destroy($id){
        AdmissionCareDetail::where('admission_id',$id)->delete();
        Admission::find($id)->delete();
        return $this->success('Admission deleted');
    }
    private function _fill_admission_data($request){
        return [
            'patient_id'=>$request->patient_id,
            'category_id'=>$request->category_id,
            'service_id'=>$request->service_id,
            'service_activity_id'=>$request->service_activity_id,
            'mhm_partner_id'=>$request->mhm_partner_id,
            'user_id'=>$request->user_id,
            'admission_priority_id'=>$request->admission_priority_id,
            'status'=>$request->status,
            'pharmacy_status'=>$request->pharmacy_status,
            'payment_status'=>$request->payment_status,
            'provisional_diagnosis'=>$request->provisional_status,
            'temp'=>$request->temp,
            'weight'=>$request->weight,
            'taSysto'=>$request->taSysto,
            'taDia'=>$request->taDia,
            'pulse'=>$request->pulse,
            'spo2'=>$request->spo2,
            'remark'=>$request->remark,
        ];
    }

    private function _fill_care_details($request,$admission_id){

        $care_details= $request->get('admission_care_details');

        if(isset($care_details['id'])){
            AdmissionCareDetail::create(
                [
                    'admission_id'=>$admission_id,
                    'activity_price_id'=>$care_details['id'],
                    'qty'=>1,
                    'total'=>$care_details['price'],
                    'payment_status'=>0
                ]
            );
        }


    }

}
