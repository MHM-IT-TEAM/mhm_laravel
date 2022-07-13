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
            'reason'=>'required|string',
            'patient_condition'=>'nullable',
            'car_id'=>'required',
            'category'=>'required',
            'departure_date'=>'nullable',
            'departure_time'=>'nullable',
            'driver'=>'required',
            'medical_team'=>'nullable',
            'oxygen_needed'=>'nullable',
            'extra_supervision_needed'=>'nullable',
            'extra_supervision_details'=>'nullable',
            'events'=>'nullable',
            'remark'=>'nullable',
            'user_id'=>'nullable'
        ];
    }
}
