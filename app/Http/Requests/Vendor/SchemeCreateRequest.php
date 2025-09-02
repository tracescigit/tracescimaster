<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class SchemeCreateRequest extends FormRequest
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
            'to'           => 'required'
        ];

        if (isset($input['product_selection_type']) && $input['product_selection_type']=='product') {
            $rules['product'] = 'required';
        }

        if (isset($input['product_selection_type']) && $input['product_selection_type']=='batch') {
            $rules['product'] = 'required';
            $rules['batch'] = 'required';
        }

        if (isset($input['product_selection_type']) && $input['product_selection_type']=='chunk') {
            $rules['from_codes']    = 'required';
            $rules['from_codes.*']  = 'required|exists:codes,code_data';
            $rules['to_codes']      = 'required';
            $rules['to_codes.*']    = 'required|exists:codes,code_data';
        }

        return $rules;
    }
}
