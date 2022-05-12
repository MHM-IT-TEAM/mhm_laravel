<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VitalSignRequest extends FormRequest
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
            'bp_l'=>'nullable',
            'bp_r'=>'nullable',
            'pulse'=>'nullable',
            'spo2'=>'nullable',
            'temp'=>'nullable',
        ];
    }
}
