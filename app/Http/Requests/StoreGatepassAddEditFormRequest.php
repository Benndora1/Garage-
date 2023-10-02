<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGatepassAddEditFormRequest extends FormRequest
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
            'jobcard' => 'required',
            'gatepass_no' => 'required',
            'Customername' => 'required',            
            'lastname' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'vehiclename' => 'required',
            'veh_type' => 'required',
            'kms' => 'required|regex:/^[0-9]*\d?(\.\d{1,2})?$/',
            'out_date' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'jobcard.required' => trans('app.Jobcard is required.'),
            'gatepass_no.required' => trans('app.Gatepass number is required.'),
            'Customername.required' => trans('app.First name is required.'),
            'lastname.required' => trans('app.Last name is required.'),
            'email.required' => trans('app.Email is required.'),
            'mobile.required' => trans('app.Contact number is required.'),
            'vehiclename.required' => trans('app.Vehicle name is required.'),
            'veh_type.required' => trans('app.Vehicle type is required.'),
            'kms.required' => trans('app.Kilometre is required.'),
            'kms.regex' => trans('app.Enter only numeric data.'),
            'out_date.required' => trans('app.Out date is required.'),
        ];

    }
}
