<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserUpdateRequest extends FormRequest
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
        $id = $this->route('id');
        $id = decrypt($id); 

        $rules =[
            'email'     => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|max:100|unique:users,email,'.$id,
            'mobile'    => 'required|min:6|max:12|regex:/^[0-9-]+$/|unique:users,phone,'.$id,
            'full_name' => 'required',
            'role'      => 'required',
        ];

        return $rules;
    }
}
