<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class BatchUpdateRequest extends FormRequest
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
            'code'          => 'required|max:50|regex:/(^[a-zA-Z0-9-()_ ]+$)/u|unique:batches,code,'.$id,
            'gs1_code'      => 'max:50',
            'mfg_date'      => 'required|date',
            'exp_date'      => 'nullable|date',
            'product'       => 'required',
        ];
    }
}
