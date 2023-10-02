<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOtherSettingEditFormRequest extends FormRequest
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
            'timezone' => 'required',
            'language' => 'required',
            'dateformat' => 'required',
            'Currency' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'timezone.required' => trans('app.Timezone is required.'),
            'language.required'  => trans('app.Language is required.'),             
            'dateformat.required' => trans('app.Date format is required.'),            
            'Currency.required' => trans('app.Currency is required.'),
        ];

    }
}
