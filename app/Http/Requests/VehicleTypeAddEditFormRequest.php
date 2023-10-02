<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleTypeAddEditFormRequest extends FormRequest
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
            'vehicaltype' => 'required|regex:/^[(a-zA-Z0-9\s)]+$/u|max:50',
        ];
    }

    public function messages()
    {
        return [
            'vehicaltype.required' => trans('app.Vehicle type is required.'),
            //'vehicaltype.alpha_spaces' => trans('app.Blank space not allowed.'),
            'vehicaltype.regex' => trans('app.Special symbols are not allowed.'),
        ];

    }
}
