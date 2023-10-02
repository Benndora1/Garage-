<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileSettingEditFormRequest extends FormRequest
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
            'firstname' => 'required|regex:/^[(a-zA-Z\s)]+$/u|max:50',
            'lastname' => 'required|regex:/^[(a-zA-Z\s)]+$/u|max:50',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'password'=> ($this->id)?'nullable|min:6|max:12|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/':'min:6|max:12|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'password_confirmation' => ($this->id)?'same:password':'same:password',
            'mobile' => 'nullable|min:6|max:16|regex:/^[- +()]*[0-9][- +()0-9]*$/',
            'image' => 'nullable|mimes:jpg,png,jpeg',
        ];
    }


    public function messages()
    {
        return [
            'firstname.required' => trans('app.First name is required.'),
            'firstname.regex'  => trans('app.First name is only alphabets and space.'),
            'firstname.max' => trans('app.First name should not more than 50 character.'),

            'lastname.required' => trans('app.Last name is required.'),
            'lastname.regex'  => trans('app.Last name is only alphabets and space.'),
            'lastname.max' => trans('app.Last name should not more than 50 character.'),
            
            'email.required' => trans('app.Email is required.'),
            'email.email'  => trans('app.Please enter a valid email address. Like : sales@dasinfomedia.com'),
            'email.unique' => trans('app.Email you entered is already registered.'),

            //'password.required' => trans('app.Password is required.'),
            'password.regex'  => trans('app.Password must be combination of letters and numbers.'),
            'password.min' => trans('app.Password length minimum 6 character.'),
            'password.max' => trans('app.Password length maximum 12 character.'),

            //'password_confirmation.required' => trans('app.Confirm password is required.'),
            'password_confirmation.same'  => trans('app.Password and Confirm Password does not match.'),
            'password_confirmation.min' => trans('app.Password length minimum 6 character.'),
            'password_confirmation.max' => trans('app.Password length maximum 12 character.'),

            //'mobile.required' => trans('app.Contact number is required.'),
            //'mobile.numeric'  => trans('app.Contact number only numbers are allowed.'),
            'mobile.min' => trans('app.Contact number minimum 6 digits.'),
            'mobile.max' => trans('app.Contact number maximum 16 digits.'),
            'mobile.regex' => trans('app.Contact number must be number, plus, minus and space only.'),

            'image.mimes' => trans('app.Image must be a file of type: Jpg, Jpeg and Png.'),
            //'image.mimes' => trans('app.Image must be a file of type: Jpg, Jpeg and Png.'),
        ];

    }
}
