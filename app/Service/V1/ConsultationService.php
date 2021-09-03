<?php


namespace App\Service\V1;


use App\Models\Consultation;
use App\Models\PatientCareDetail;
use App\Models\VitalSign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ConsultationService
{

    public function store($request){
        $consultation= new Consultation();
        $consultation->fill($this->_fill_data($request));
        $consultation->senior_informed= $this->_check_senior($request['senior_informed']);
        dd($consultation);
    }

    private function _check_senior($seniors){
        $senior_informed='';
        if(count($seniors)>0){
            foreach ($seniors as $senior){
                $senior_informed.=$senior .",";
            }
            $senior_informed=rtrim($senior_informed,',');
        }
        return $senior_informed;

    }
    private function _fill_data($request){
        $request= collect($request);
        return $request->except(['patient_care_details','senior_informed']);
    }

}
