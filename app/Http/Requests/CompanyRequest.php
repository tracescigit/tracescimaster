<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'company_name'  => 'required|max:100',
            'company_address'  => 'required',
            'company_city'  => 'required',
            'company_country'  => 'required',
            'tax_registration_number'  => 'required',
            'identity_proof'  => 'required|mimes:pdf,jpg,jpeg|max:2048',
            'registration_certificate'  => 'required|mimes:pdf,jpg,jpeg|max:2048',
            'gst_or_vat_certificate'  => 'required|mimes:pdf,jpg,jpeg|max:2048',
        ];
    }
}
