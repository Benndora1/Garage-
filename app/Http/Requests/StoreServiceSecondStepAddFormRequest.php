<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceSecondStepAddFormRequest extends FormRequest
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
            'out_date' => 'required',
            'kms' => 'required',                  
        ];
    }


    public function messages()
    {
        return [
            'out_date.required' => trans('app.Out time date is required.'),

            'kms.required' => trans('app.Kilometre is required.'),
            //'kms.integer' => trans('app.Only numeric data allowed.'),            
            //'kms.regex' => trans('app.Only numeric data allowed.'),
        ];

    }
}
