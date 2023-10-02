<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierAddEditFormRequest extends FormRequest
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
            'firstname' => 'nullable|regex:/^[(a-zA-Z\s)]+$/u|max:50',
            'lastname' => 'nullable|regex:/^[(a-zA-Z\s)]+$/u|max:50',
            'displayname' => 'required|max:100|regex:/^[a-zA-Z][a-zA-Z0-9\s\.\@\-\_]*$/',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'mobile' => 'required|min:6|max:16|regex:/^[- +()]*[0-9][- +()0-9]*$/',
            'landlineno' => 'nullable|min:6|max:16|regex:/^[- +()]*[0-9][- +()0-9]*$/',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'country_id' => 'required',
            'address' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'firstname.regex'  => trans('app.First name is only alphabets and space.'),
            'firstname.max' => trans('app.First name should not more than 50 character.'),

            'lastname.regex'  => trans('app.Last name is only alphabets and space.'),
            'lastname.max' => trans('app.Last name should not more than 50 character.'),
            
            'displayname.required' => trans('app.Company name is required.'),
            'displayname.regex'  => trans('app.Only alphanumeric, space, dot, @, _, and - are allowed.'),
            'displayname.max' => trans('app.Company name should not more than 100 character.'),

            //'dob.required' => trans('app.Date of birth is required.'),

            'email.required' => trans('app.Email is required.'),
            'email.email'  => trans('app.Please enter a valid email address. Like : sales@dasinfomedia.com'),
            'email.unique' => trans('app.Email you entered is already registered.'),

            'mobile.required' => trans('app.Contact number is required.'),
            //'mobile.numeric'  => trans('app.Contact number only numbers are allowed.'),
            'mobile.min' => trans('app.Contact number minimum 6 digits.'),
            'mobile.max' => trans('app.Contact number maximum 16 digits.'),
            'mobile.regex' => trans('app.Contact number must be number, plus, minus and space only.'),

            'landlineno.numeric'  => trans('app.Landline number only numbers are allowed.'),
            //'landlineno.digits_between' => trans('app.Landline number must be digits between 6 to 12 digits.'),
            'landlineno.min' => trans('app.Landline number minimum 6 digits.'),
            'landlineno.max' => trans('app.Landline number maximum 16 digits.'),
            'landlineno.regex' => trans('app.Landline number must be number, plus, minus and space only.'),

            //'image.image' => trans('app.Image must be a file of type: Jpg, Jpeg and Png.'),
            'image.mimes' => trans('app.Image must be a file of type: Jpg, Jpeg and Png.'),

            'country_id.required' => trans('app.Country field is required.'),
            'address.required'  => trans('app.Address field is required.'),
        ];

    }
}
