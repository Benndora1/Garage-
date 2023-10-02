<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneralSettingEditFormRequest extends FormRequest
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
            'System_Name' => 'required|regex:/^[a-zA-Z][a-zA-Z0-9\s]*$/',
            'Phone_Number' => 'required|min:6|max:16|regex:/^[- +()]*[0-9][- +()0-9]*$/',
            'Email' => 'required|email',
            'address' => 'required',
            'country_id' => 'required',
            'Logo_Image' => 'nullable|mimes:jpg,png,jpeg',
            'Cover_Image' => 'nullable|mimes:jpg,png,jpeg',
            'Paypal_Id' => 'nullable|email',
        ];
    }

    public function messages()
    {
        return [
            'System_Name.required' => trans('app.System name is required.'),
            'System_Name.regex' => trans('app.System name must be alphabets, numbers and space.'),

            'Phone_Number.required'  => trans('app.Phone number is required.'), 
            'Phone_Number.min' => trans('app.Phone number minimum 6 digits.'),
            'Phone_Number.max' => trans('app.Phone number maximum 16 digits.'),
            'Phone_Number.regex' => trans('app.Phone number must be number, plus, minus and space only.'),
            
            'Email.required' => trans('app.Email is required.'),
            'Email.email'  => trans('app.Please enter a valid email address. Like : sales@dasinfomedia.com'),
            
            'address.required' => trans('app.Address is required.'),

            'country_id.required' => trans('app.Country name is required.'),

            'Logo_Image.mimes' => trans('app.Image must be Jpg, Jpeg and Png only.'),

            'Cover_Image.mimes' => trans('app.Image must be Jpg, Jpeg and Png only.'),

            'Paypal_Id.email' => trans('app.Please enter valid email address.'),
        ];

    }
}
