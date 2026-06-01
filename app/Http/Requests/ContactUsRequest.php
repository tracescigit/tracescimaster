<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
{

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
            'name' => 'required|min:3|regex:/^[a-zA-Z0-9 ]+$/u',

            'email' => 'required|email|max:100',

            'mobile' => 'required|regex:/^[0-9\s\-\+\(\)]{10,15}$/',

            'message' => 'required|min:3',

            'g-recaptcha-response' => 'required'
        ];
    }
}
