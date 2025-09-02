<?php

namespace App\Http\Requests\Admin\LabelOrder;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLabelOrderRequest extends FormRequest
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
            'remarks'=>'required',
            'status'=>'required'
        ];
    }
}
