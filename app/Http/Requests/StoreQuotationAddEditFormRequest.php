<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotationAddEditFormRequest extends FormRequest
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
            'Customername' => 'required',
            'vehicalname' => 'required',
            'date' => 'required',
            'repair_cat' => 'required',
            'charge' => 'required|regex:/^[0-9]*$/',
            'title' => 'regex:/^[a-zA-Z][a-zA-Z0-9\s\.\-\_]*$/',
        ];
    }

    public function messages()
    {
        return [
            'Customername.required' => trans('app.Customer name is required.'),
            'vehicalname.required' => trans('app.Vehicle name is required.'),
            'date.required' => trans('app.Service date is required.'),
            'repair_cat.required' => trans('app.Repair category is required.'),
            'charge.required' => trans('app.Service charge is required.'),    
            'charge.regex'  => trans('app.Service charge is only number data.'),  
            'title.regex'  => trans('app.First character is an alphabet after alphanumeric, space, dot, comma, hyphen and underscore are allowed.'),
        ];
    }
}
