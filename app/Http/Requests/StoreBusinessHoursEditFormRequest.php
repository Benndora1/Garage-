<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessHoursEditFormRequest extends FormRequest
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
            'adddate' => 'required',
            'addtitle' => 'required|max:100|regex:/^[a-zA-Z][a-zA-Z0-9\s\.\@\-\_\,]*$/',
            'adddescription' => 'nullable|max:300|regex:/^[a-zA-Z][a-zA-Z0-9\s\.\@\-\_\,]*$/',
        ];
    }

    public function messages()
    {
        return [
            'adddate.required' => trans('app.Date is required.'),

            'addtitle.required'  => trans('app.Title is required.'),             
            'addtitle.regex'  => trans('app.After alphabet alphanumeric, space, dot, @, _, and - are allowed.'),
            'addtitle.max' => trans('app.Title field should not more than 100 character.'),

            'adddescription.regex'  => trans('app.After alphabet alphanumeric, space, dot, @, _, and - are allowed.'),
            'adddescription.max' => trans('app.Description should not more than 300 character.'),         
        ];

    }
}
