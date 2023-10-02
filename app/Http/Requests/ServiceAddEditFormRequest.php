<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceAddEditFormRequest extends FormRequest
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
            'jobno' => 'required',
            'Customername' => 'required',
            'vehicalname' => 'required',
            'date' => 'required',
            'AssigneTo' => 'required',
            'repair_cat' => 'required',
            'charge' => 'required|numeric|regex:/^[0-9]*$/',
            'title' => 'regex:/^[a-zA-Z][a-zA-Z0-9\s\.\-\_]*$/',
        ];
    } 

    public function messages()
    {
        return [
            'jobno.required' => trans('app.Jobcard number is required.'),
            'Customername.required' => trans('app.Customer name is required.'),
            'vehicalname.required' => trans('app.Vehicle name is required.'),
            'date.required' => trans('app.Service date is required.'),
            'AssigneTo.required' => trans('app.Assigne to is required.'),
            'repair_cat.required' => trans('app.Repair category is required.'),
            'charge.required' => trans('app.Service charge is required.'),       
            'charge.numeric' => trans('app.Service charge is only numeric data.'),
            'charge.regex'  => trans('app.Service charge is only number data.'),   
            'title.regex'  => trans('app.First character is an alphabet after alphanumeric, space, dot, comma, hyphen and underscore are allowed.'),
        ];
    }
}
