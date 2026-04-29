<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TemplateEditRequest extends FormRequest
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
            'name' => [
                'required',
                'max:100',
                'regex:/^[a-zA-Z0-9\-()_ ]+$/u',
                Rule::unique('product_templates', 'name')->ignore($id),
            ],
        ];
    }
}
