<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationUpdateRequest extends FormRequest
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

        $user = User::find($id);

        return [
            'email'   => 'required|email|max:100|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,'.$id,
            'name'    => 'required|max:100|regex:/(^[a-zA-Z0-9-()_ ]+$)/u',
            'login_password' => 'nullable|string|max:25|min:8|regex:/^(?=.*[a-z])(?=.*\\d).{8,}$/i',
            'mobile'  => 'required|min:6|max:12|regex:/^[0-9-]+$/|unique:users,phone,'.$id,
            'company_name'  => 'required|max:100',
            'company_address'  => 'required',
            'self_kyc'  => 'nullable|mimes:pdf,jpg,jpeg,png|max:1024',
            'company_roc'  => 'nullable|mimes:pdf,jpg,jpeg,png|max:1024',
            'company_gst'  => 'nullable|mimes:pdf,jpg,jpeg,png|max:1024',
            'default_plan' => 'required',
            'city' => 'required',
            'country' => 'required',
            'tax_registration_number' => 'required|unique:companies,gst,'.$user->getCompany->id,
        ];
    }
}
