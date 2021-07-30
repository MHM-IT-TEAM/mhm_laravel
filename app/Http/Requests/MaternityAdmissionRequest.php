<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaternityAdmissionRequest extends FormRequest
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
            'patient_id'=>'required|integer',
            'hospital_service_division_id'=>'required|integer',
            'bed_id'=>'required|integer',
            'code'=>'required|string',
            'date'=>'required|date',
            'time'=>'required',
            'ga'=>'required',
            'severe_abdominal_pain'=>'nullable',
            'booked_delivery'=>'nullable',
            'breathing_delivery'=>'nullable',
            'complication_explanation'=>'nullable',
            'convulsions'=>'nullable',
            'cpn_ref'=>'nullable|integer',
            'due_date_method'=>'nullable|',
            'due_date_labor'=>'nullable|',
            'emergency_case'=>'nullable|',
            'provisional_diagnosis'=>'nullable|',
            'final_diagnosis'=>'nullable|',
            'high_fever'=>'nullable|',
            'labor_pain'=>'nullable|',
            'other_danger'=>'nullable|',
            'planned_oc'=>'nullable|',
            'pregnancy_complication'=>'nullable|',
            'severe_headache'=>'nullable|',
            'vaginal_bleeding'=>'nullable|',
            'bp_left'=>'nullable',
            'bp_right'=>'nullable',
            'pulse'=>'nullable|numeric',
            'spo2'=>'nullable',
            'temp'=>'nullable',
            'weight'=>'nullable',
        ];
    }
}
