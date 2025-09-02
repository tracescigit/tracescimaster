<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MaterialTypeUpdateRequest extends FormRequest
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
        $id = $this->route('id');
        $id = decrypt($id); 

        return [
            'type'          => 'required|max:100|regex:/(^[a-zA-Z0-9-()_ ]+$)/u|unique:material_types,type,'.$id,
            'gsm'           => 'required|numeric|max:99999999.99|regex:/^[0-9.]+$/',
            'cost'          => 'required|numeric|max:99999999.99|regex:/^[0-9.]+$/',
            'cost_usd'      => 'required|numeric|max:99999999.99|regex:/^[0-9.]+$/',
            'status'        => 'required',
        ];
    }
}
