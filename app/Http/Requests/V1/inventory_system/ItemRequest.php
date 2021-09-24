<?php

namespace App\Http\Requests\V1\inventory_system;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'barcode'=>'nullable',
            'code'=>'nullable',
            'description'=>'required',
            'item_type_id'=>'required',
            'item_unit_id'=>'required',
            'administration_id'=>'nullable',
            'location_id'=>'nullable',
            'perUnit'=>'nullable',
            'dci'=>'nullable',
            'price'=>'nullable',
            'status'=>'nullable',
            'purpose_of_use'=>'nullable'
        ];
    }
}
