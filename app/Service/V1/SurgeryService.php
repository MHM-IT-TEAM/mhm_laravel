<?php


namespace App\Service\V1;


use App\Models\Admission;
use App\Models\Surgery;
use App\Models\SurgeryUsedMedicine;
use Illuminate\Database\Eloquent\Model;

class SurgeryService
{
    public function store($request){
        $surgery= new Surgery();
        $surgery->fill($this->_fillData($request))->save();
        $admission= Admission::find($request->admission_id);
        $admission->status='DONE';
        $admission->save();
        $this->_save_medicines_data($request->surgery_used_medicines,$surgery->id);
        return response($surgery);
    }
    public function update($id,$request){
        $surgery=Surgery::find($id);
        $surgery->update($this->_fillData($request));
        SurgeryUsedMedicine::where('surgery_id',$id)->delete();
        $this->_save_medicines_data($request->surgery_used_medicines,$id);
        if($request->dismissal_outcome==='stay' && ! $request->has('is_edit')){
            $admission= Admission::find($request->admission_id);
            $new_admission= $admission->replicate()->fill([
                'service_activity_id'=>45,
                'admission_type_id'=>2,
                'status'=>'RUNNING',
                'payment_status'=>'PAID'
            ]);
            $new_admission->save();
        }
    }

    private function _fillData($request){
        return [
            'admission_id'=>$request->admission_id,
            'patient_id'=>$request->patient_id,
            'date_of_surgery'=>$request->date_of_surgery,
            'time_surgery'=>$request->time_surgery,
            'time_anesthesia'=>$request->time_anesthesia,
            'time_is_anesthesia_finished'=>$request->time_is_anesthesia_finished,
            'time_is_surgery_finished'=>$request->time_is_surgery_finished,
            'type_of_surgery'=>$request->type_of_surgery,
            'reason_for_surgery'=>$request->reason_for_surgery,
            'comment'=>$request->comment,
            'status'=>$request->status,
            'emla_on'=>$request->emla_on,
            'emla_off'=>$request->emla_off,
            'start_time_no_food'=>$request->start_time_no_food,
            'taDia'=>$request->taDia,
            'taSysto'=>$request->taSysto,
            'temp'=>$request->temp,
            'weight'=>$request->weight,
            'pulse'=>$request->pulse,
            'spo2'=>$request->spo2,
            'surgery_report'=>$request->surgery_report,
            'dismissal_outcome'=>$request->dismissal_outcome,
            'next_surgery'=>$request->next_surgery,
            'next_surgery_date'=>$request->next_surgery_date,
            'wound_care'=>$request->wound_care,
            'wound_care_date'=>$request->wound_care_date,
            'appointment_for_followup'=>$request->appointment_for_followup,
            'surgeons'=>$request->surgeons,
            'doctors'=>$request->doctors,
            'anesthetists'=>$request->anesthetists,
            'nurses'=>$request->nurses,
            'midwives'=>$request->midwives,
            'other_people'=>$request->other_people,
        ];
    }

    private function _save_medicines_data($request,$surgery_id){
        foreach(collect($request) as $data){
            SurgeryUsedMedicine::create([
                'surgery_id'=>$surgery_id,
                'medicine'=>$data['medicine'],
                'dosage'=>$data['dosage'],
                'time'=>$data['time']
            ]);
        }
    }

}
