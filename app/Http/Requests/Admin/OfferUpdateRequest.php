<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OfferUpdateRequest extends FormRequest
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

        return [
            'title'        => 'required|max:100|regex:/(^[a-zA-Z0-9-()_ ]+$)/u',
            'code'         => 'required|unique:offers,code,'.$id,
            'type'         => 'required',
            'value'        => 'required|numeric',
            'status'       => 'required',
            'description'  => 'nullable|max:200',
        ];
    }
}
