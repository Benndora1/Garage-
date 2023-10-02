<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/*This file is form invoice salespart*/
class StoreInvoiceEditFormRequest extends FormRequest
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
            'Vehicle' => 'required',
            'Date' => 'required',
            'Status' => 'required',
            'Payment_type' => 'required',
            'grandtotal' => 'required',
            'paidamount' => 'required',                      
        ];
    } 

    public function messages()
    {
        return [
            'Vehicle.required' => trans('app.Vehicle name is required.'),
            'Date.required' => trans('app.Invoice date is required.'),
            'Status.required' => trans('app.Status is required.'),
            'Payment_type.required' => trans('app.Payment type is required.'),
            'grandtotal.required'  => trans('app.Grand total is required.'),
            'paidamount.required'  => trans('app.Paid amount is required.'),
        ];
    }
}
