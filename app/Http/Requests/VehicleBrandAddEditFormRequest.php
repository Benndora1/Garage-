<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleBrandAddEditFormRequest extends FormRequest
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
            'vehicalbrand' => 'required|regex:/^[(a-zA-Z0-9\s)]+$/u|max:50',
            'vehicaltypes' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'vehicaltypes.required' => trans('app.Vehicle type is required.'),
            'vehicalbrand.required' => trans('app.Vehicle brand is required.'),
            //'vehicaltype.alpha_spaces' => trans('app.Blank space not allowed.'),
            'vehicalbrand.regex' => trans('app.Special symbols are not allowed.'),
        ];

    }
}
