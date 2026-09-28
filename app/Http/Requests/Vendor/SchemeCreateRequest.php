<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class SchemeCreateRequest extends FormRequest
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
        $input = $this->all();

        $rules = [
            'title' => 'required',
            'from'  => 'required|date|after_or_equal:today',
            'to'    => 'required|date|after_or_equal:from',
        ];

        $messages = [
            'title.required' => 'Scheme title is required.',

            'from.required' => 'From date is required.',
            'from.date' => 'Please enter a valid From date.',
            'from.after_or_equal' => 'From date must be today or a future date.',

            'to.required' => 'To date is required.',
            'to.date' => 'Please enter a valid To date.',
            'to.after_or_equal' => 'To date must be the same as or after the From date.',
        ];


        if (
            isset($input['product_selection_type']) &&
            $input['product_selection_type'] == 'product'
        ) {
            $rules['product'] = 'required';

            $messages['product.required'] = 'Please select a product.';
        }


        if (
            isset($input['product_selection_type']) &&
            $input['product_selection_type'] == 'batch'
        ) {
            $rules['product'] = 'required';
            $rules['batch'] = 'required';

            $messages['product.required'] = 'Please select a product.';
            $messages['batch.required'] = 'Please select a batch.';
        }


        if (
            isset($input['product_selection_type']) &&
            $input['product_selection_type'] == 'chunk'
        ) {
            $rules['from_codes'] = 'required|array';
            $rules['from_codes.*'] = 'required|exists:codes,code_data';

            $rules['to_codes'] = 'required|array';
            $rules['to_codes.*'] = 'required|exists:codes,code_data';

            $messages['from_codes.required'] = 'At least one From Code is required.';
            $messages['from_codes.array'] = 'From Codes must be a valid list.';
            $messages['from_codes.*.required'] = 'From Code is required.';
            $messages['from_codes.*.exists'] = 'The From Code does not exist.';

            $messages['to_codes.required'] = 'At least one To Code is required.';
            $messages['to_codes.array'] = 'To Codes must be a valid list.';
            $messages['to_codes.*.required'] = 'To Code is required.';
            $messages['to_codes.*.exists'] = 'The To Code does not exist.';
        }


        $this->validate($rules, $messages);

        return $rules;
    }
}
