<?php

namespace App\Http\Requests\V1\patient_system;

use Illuminate\Foundation\Http\FormRequest;

class ExternalConsultationRequest extends FormRequest
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
            'user_id'=>'required',
            'service'=>'required',
            'transport_needed'=>'nullable',
            'car_id'=>'nullable',
            'km_start'=>'nullable',
            'km_end'=>'nullable',
            'reason'=>'required',
            'remark'=>'nullable',
            'admission_id'=>'required',
        ];
    }
}
