<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'patient_id'=>'integer|required',
            'service_activity_id'=>'integer|required',
            'user_id'=>'integer|required',
            'admission_priority_id'=>'integer|required',
            'status'=>'nullable',
            'pharmacy_status'=>'nullable',
            'payment_status'=>'nullable',
            'provisional_diagnosis'=>'nullable',
            'temp'=>'nullable',
            'weight'=>'nullable',
            'taSysto'=>'integer|nullable',
            'taDia'=>'integer|nullable',
            'pulse'=>'integer|nullable',
            'spo2'=>'nullable',
            'remark'=>'nullable',
        ];
    }
}
