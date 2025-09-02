<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name'          => 'required',
            'brand'         => 'required',
            'price'         => 'required',
            'status'        => 'required',
            'file'          => 'nullable|mimes:png,jpg,jpeg',
        ];
    }
}
