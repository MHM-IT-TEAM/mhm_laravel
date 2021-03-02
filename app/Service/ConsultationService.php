<?php


namespace App\Service;


use App\Models\Consultation;
use App\Models\PatientCareDetail;
use App\Models\VitalSign;
use Carbon\Carbon;

class ConsultationService
{
    private $consult_data;
    private $invoices;
    private $vitalSigns;
    public function __construct($formData)
    {
        $this->invoices=$formData->item;
        $this->vitalSigns= $formData->vitalSign;
        $this->consult_data=[
            'patient_id'=>$formData->patId,
            'type_consult_id'=>$formData->type_consult,
            'priority'=>$formData->priority
        ];
    }
    public function store(){
      // insert into the consultation table
        $consult= new Consultation();
        $patCare= new PatientCareDetail();
        $consult->fill($this->consult_data)->save();
        $consult_id= $consult->id;
        // check if the consultation contains invoices items

        if(count($this->invoices)>0){
            foreach ($this->invoices as $item){
                $patCare->insert([
                    'consultation_id'=>$consult_id,
                    'service_prices_id'=>$item['id'],
                    'qty'=>$item['quantity'],
                    'total'=>$item['totLine']
                ]);
            }
        }
        //check if the consultation contains vitalSigns data

        if(isset($this->vitalSigns)){
            VitalSign::insert([
                'temp'=>$this->vitalSigns["temp"],
                'weight'=>$this->vitalSigns["weight"],
                'taSysto'=>$this->vitalSigns["taSysto"],
                'taDia'=>$this->vitalSigns["taDia"],
                'pulse'=>$this->vitalSigns["pulse"],
                'patient_id'=>$this->consult_data["patient_id"]
            ]);

        }

        return Consultation::whereDate('created_at',Carbon::today())->get();
    }

}
