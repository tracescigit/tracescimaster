<?php

namespace App\Http\Requests\Admin;

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
            'password' => 'nullable|string|max:25|min:8|regex:/^(?=.*[a-z])(?=.*\\d).{8,}$/i',
            'mobile'  => 'required|min:6|max:12|regex:/^[0-9-]+$/|unique:users,phone,'.$id,
        ];

    }
}
