<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStripeSettingEditFormRequest extends FormRequest
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
            'publish_key' => 'required',
            'secret_key' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'publish_key.required' => trans('app.Publish key is required.'),
            'secret_key.required'  => trans('app.Secret key is required.'),             
       
        ];

    }
}
