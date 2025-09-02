<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationCreateRequest extends FormRequest
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
            'email'   => 'required|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|max:100',
            'name'    => 'required|max:100|regex:/(^[a-zA-Z0-9-()_ ]+$)/u',
            'mobile'  => 'required|min:6|max:12|regex:/^[0-9-]+$/|unique:users,phone',
            'company_name'  => 'required|max:100',
            'company_address'  => 'required',
            'self_kyc'  => 'required|mimes:pdf,jpg,jpeg,png|max:1024',
            'company_roc'  => 'required|mimes:pdf,jpg,jpeg,png|max:1024',
            'company_gst'  => 'required|mimes:pdf,jpg,jpeg,png|max:1024',
            'default_plan' => 'required',
            'city' => 'required',
            'country' => 'required',
            'tax_registration_number' => 'required|unique:companies,gst',
        ];
    }
}
