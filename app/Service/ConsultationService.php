<?php


namespace App\Service;


use App\Models\Consultation;
use App\Models\PatientCareDetail;
use App\Models\VitalSign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ConsultationService
{
    private $consult_data;
    private $invoices;
    private $vitalSigns;
    public function __construct($formData)
    {
        $this->invoices=$formData->patient_care_details;
        $this->consult_data=[
            'patient_id'=>$formData->patient['id'],
            'type_consult_id'=>$formData->type_consult_id,
            'priority'=>$formData->priority,
            'payment_status'=>'UNPAID',
            'status'=>$formData->status,
            'temp'=>$formData->temp,
            'weight'=>$formData->weight,
            'pulse'=>$formData->pulse,
            'taSysto'=>$formData->taSysto,
            'taDia'=>$formData->taDia,
            'spo2'=>$formData->spo2,
            'blue_priority_reason'=>$formData->blue_priority_reason,
            'remark'=>$formData->remark,
            'responsible'=>$formData->responsible,

        ];
    }
    public function store(){
      // insert into the consultation table
        $consult= new Consultation();
        $consult->fill($this->consult_data)->save();
        $consult_id= $consult->id;
        // check if the consultation contains invoices items
        if(count($this->invoices)>0){
            foreach ($this->invoices as $item){
                $this->_fill_invoice($item,$consult_id);
            }
        }
    }
    public function update($id){
        $consult= Consultation::find($id);
        //update the consultations table
        $consult->fill($this->consult_data)->save();
        //update the invoices
        PatientCareDetail::where('consultation_id',$id)->delete();
        if(count($this->invoices)>0){
            foreach ($this->invoices as $item){
                $this->_fill_invoice($item,$id);
            }
        }
    }
    private function _fill_invoice($src,$consultation_id){
        $patCare= new PatientCareDetail();
        $patCare->create([
            'consultation_id'=>$consultation_id,
            'service_prices_id'=>$src['id'],
            'qty'=>$src['qty'],
            'total'=>$src['amount']
        ]);
    }

}
