<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the input is authorized to make this request.
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

        $rules = [
            'email'     => 'required|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|max:100',
            'mobile'    => 'required|unique:users,phone',
            'full_name' => 'required',
            'role'      => 'required',
        ];

        return $rules;
    }
}
