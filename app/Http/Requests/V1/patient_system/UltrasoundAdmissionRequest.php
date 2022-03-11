<?php

namespace App\Http\Requests\V1\patient_system;

use Illuminate\Foundation\Http\FormRequest;

class UltrasoundAdmissionRequest extends FormRequest
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
            'admission_id'=>'required',
            'patient_id'=>'required',
            'last_period_date'=>'nullable',
            'edd_calculated'=>'nullable',
            'edd_ultrasound'=>'nullable',
            'edd_method'=>'nullable',
            'unknown_lpd'=>'nullable',
            'is_patient_pregnant'=>'nullable',
            'remark_when_patient_not_pregnant'=>'nullable',
            'count_of_fetus'=>'nullable',
            'calculated_ga'=>'nullable',
            'ultrasound_ga'=>'nullable',
            'corrected_ga'=>'nullable',
            'medical_staff'=>'nullable',
            'user_id'=>'required',
            'multiple_pregnancy'=>'nullable',
            'status'=>'required'

        ];
    }
}
