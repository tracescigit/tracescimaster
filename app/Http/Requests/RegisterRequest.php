<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class RegisterRequest extends FormRequest
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
        return [
            'email'   => ['required', 'string', 'email', 'max:191',Rule::unique('users')->where(function ($query) use ($request) {
                return $query->where('status','!=','2');
            })],
            'name'    => 'required|max:100|regex:/(^[a-zA-Z ]+$)/u',
            'mobile'  => ['required', 'string', 'max:12',Rule::unique('users','phone')->where(function ($query) use ($request) {
                return $query->where('status','!=','2');
            })]
        ];
    }
}
