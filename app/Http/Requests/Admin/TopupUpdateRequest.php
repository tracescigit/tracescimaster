<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TopupUpdateRequest extends FormRequest
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
            'title'         => 'required|max:100|regex:/(^[a-zA-Z0-9-()_ ]+$)/u',
            'credits'       => 'required|numeric|min:1',
            'price_inr'     => 'required|numeric|max:99999999.99|regex:/^[0-9.]+$/',
            'price_usd'     => 'required|numeric|max:99999999.99|regex:/^[0-9.]+$/',
            'status'        => 'required',
        ];
    }
}
