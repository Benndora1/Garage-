<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceAddEditFormRequest extends FormRequest
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
            'Invoice_type' => 'required',
            'Invoice_Number' => 'required',
            'Customer' => 'required',
            'Job_card' => 'required',
            'Vehicle' => 'required',
            'Customer' => 'required',
            'Date' => 'required',
            'Total_Amount' => 'required',
            'Status' => 'required',
            'Payment_type' => 'required',
            'grandtotal' => 'required',
            'paidamount' => 'required',                      
        ];
    } 

    public function messages()
    {
        return [
            'Invoice_type.required' => trans('app.Invoice type is required.'),
            'Invoice_Number.required' => trans('app.Invoice number is required.'),
            'Customer.required' => trans('app.Customer name is required.'),
            'Job_card.required' => trans('app.Jobcard number is required.'),
            'Vehicle.required' => trans('app.Vehicle name is required.'),
            'Customer.required' => trans('app.Customer name is required.'),
            'Date.required' => trans('app.Invoice date is required.'),
            'Total_Amount.required' => trans('app.Total amount is required.'),
            'Status.required' => trans('app.Status is required.'),
            'Payment_type.required' => trans('app.Payment type is required.'),
            'grandtotal.required'  => trans('app.Grand total is required.'),
            'paidamount.required'  => trans('app.Paid amount is required.'),
        ];
    }
}
