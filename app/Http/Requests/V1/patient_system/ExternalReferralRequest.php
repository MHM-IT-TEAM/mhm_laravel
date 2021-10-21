<?php

namespace App\Http\Requests\V1\patient_system;

use Illuminate\Foundation\Http\FormRequest;

class ExternalReferralRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'medical_center_id'=>'required',
            'admission_id'=>'required',
            'other_medical_center'=>'nullable',
            'service'=>'nullable',
            'reason'=>'required|string',
            'patient_condition'=>'nullable',
            'car_id'=>'required',
            'departure_mhm'=>'nullable',
            'departure_destination'=>'nullable',
            'arrival_mhm'=>'nullable',
            'arrival_destination'=>'nullable',
            'driver'=>'required',
            'midwife'=>'nullable',
            'midwife_1'=>'nullable',
            'anesthetist'=>'nullable',
            'nurse'=>'nullable',
            'oxigen_needed'=>'nullable',
            'extra_supervision_needed'=>'nullable',
            'extra_supervision_details'=>'nullable',
            'events'=>'nullable',
            'patient_condition_at_discharge'=>'nullable',
            'remark'=>'nullable',
            'user_id'=>'nullable'
        ];
    }
}
