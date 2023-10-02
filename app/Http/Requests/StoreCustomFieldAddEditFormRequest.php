<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomFieldAddEditFormRequest extends FormRequest
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
            'formname' => 'required',
            'labelname' => 'required|max:50|regex:/^[a-zA-Z][a-zA-Z0-9\s\.\@\-\_]*$/',
            'typename' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'formname.required' => trans('app.Form name is required.'),
            'labelname.required'  => trans('app.Label name is required.'),
            'labelname.regex'  => trans('app.Start should be alphabets only after supports alphanumeric, space, dot, @, _, and - are allowed.'),
            'labelname.max' => trans('app.Label name should not more than 50 character.'),
            'typename.required' => trans('app.Type is required.'),
        ];

    }
}
