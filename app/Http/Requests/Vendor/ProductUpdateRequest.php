<?php

namespace App\Http\Requests\Vendor;

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
            'name'          => 'required|max:100|regex:/(^[a-zA-Z0-9-()_ ]+$)/u',
            'brand'         => 'required|max:100|regex:/(^[a-zA-Z0-9-()_ ]+$)/u',
            'price'         => 'required|numeric|max:99999999.99|regex:/^[0-9.]+$/',
            'status'        => 'required',
            'file'          => 'nullable|mimes:png,jpg,jpeg|image|max:500000',
            'product_label' => 'nullable|mimes:png,jpg,jpeg|image|max:500000'
        ];
    }
}
