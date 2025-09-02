<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LabelSizeUpdateRequest extends FormRequest
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
            'width'     => 'required|numeric|max:99999999.99|regex:/^[0-9.]+$/',
            'height'    => 'required|numeric|max:99999999.99|regex:/^[0-9.]+$/',
            'file'      => 'nullable|mimes:png,jpg,jpeg|image|max:500000',
        ];
    }
}
