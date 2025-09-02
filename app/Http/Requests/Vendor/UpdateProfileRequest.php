<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
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
        $id = Auth::id();

        return [
            'email'   => 'required|email|unique:users,email,'.$id,
            'name'    => 'required|max:100|regex:/(^[a-zA-Z0-9 ]+$)/u',
            'login_password' => 'nullable|string|max:25|min:8|regex:/^(?=.*[a-z])(?=.*\\d).{8,}$/i',
            'mobile'  => 'required|min:6|max:12|regex:/^[0-9-]+$/|unique:users,phone,'.$id,
            'company_name'  => 'required|max:100',
            'company_address'  => 'required',
            'company_cin'  => 'required|min:21|max:21',
            'company_gst_no'  => 'required|string|min:15|max:15|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            'self_kyc'  => 'nullable|mimes:txt,jpg,jpeg,pdf,doc,docx|max:500000',
            'company_roc'  => 'nullable|mimes:txt,jpg,jpeg,pdf,doc,docx|max:500000',
            'company_gst'  => 'nullable|mimes:txt,jpg,jpeg,pdf,doc,docx|max:500000',
        ];

    }
}
