<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MaterialTypeCreateRequest extends FormRequest
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
            'type'          => 'required|max:100|regex:/(^[a-zA-Z0-9-()_ ]+$)/u|unique:material_types,type',
            'gsm'           => 'required|numeric|max:99999999.99|regex:/^[0-9.]+$/',
            'cost'          => 'required|numeric|max:99999999.99|regex:/^[0-9.]+$/',
            'status'        => 'required',
        ];
    }
}
