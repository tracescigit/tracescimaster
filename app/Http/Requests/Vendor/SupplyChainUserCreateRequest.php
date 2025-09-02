<?php

namespace App\Http\Requests\Vendor;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SupplyChainUserCreateRequest extends FormRequest
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
    public function rules(Request $request)
    {

        $input = $request->all();

        $user  = null; 

        $rules =  [
            'email'     => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users',
            'mobile'    => 'required|unique:users,phone',
            'full_name' => 'required',
            'role'      => 'required',
            'address'   => 'required',
        ];

        if (isset($input['mobile']) || isset($input['email'])) {
            $user = User::where('email',$input['email'])->orWhere('phone',$input['mobile'])->first();
        }

        if ($user && $user->type=='0') {
            $rules['email']  = 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix';
            $rules['mobile'] = 'required';
        }

        return $rules;
    }
}
