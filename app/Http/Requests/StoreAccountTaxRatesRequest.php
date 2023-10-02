<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountTaxRatesRequest extends FormRequest
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
        return [
            'taxrate' => 'required|max:50|regex:/^[a-zA-Z][a-zA-Z0-9\s\.\@\-\_\%\()]*$/',
            'tax' => 'required|digits_between:1,4',
            
            
        ];
    }

    public function messages()
    {
        return [
            'taxrate.required' => trans('app.Tax name is required.'),
            'taxrate.regex'  => trans('app.Only alphanumeric, space, dot, @, _, % and - are allowed.'),
            'taxrate.max' => trans('app.Tax name should not more than 50 character.'),

            'tax.required' => trans('app.Tax rate is required.'),
            'tax.digits_between' => trans('app.The tax must be between 1 and 4 digits.'),
            
        ];

    }
}
