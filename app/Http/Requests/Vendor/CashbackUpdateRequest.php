<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class CashbackUpdateRequest extends FormRequest
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
        $input = $this->all();

        $rules = [
            'title'        => 'required',
            'from'         => 'required',
            'description'  => 'required',
            'to'           => 'required'
        ];
        
        $rules['from_codes']    = 'required';
        $rules['from_codes.*']  = 'required|exists:codes,code_data';
        $rules['to_codes']      = 'required';
        $rules['to_codes.*']    = 'required|exists:codes,code_data';

        return $rules;
    }
}
