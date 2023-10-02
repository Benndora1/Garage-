<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleSaleAddEditFormRequest extends FormRequest
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
            'bill_no' => 'required',
            'date' => 'required',
            'cus_name' => 'required',
            'salesmanname' => 'required',
            'vehi_bra_name' => 'required',
            'vehicale_name' => 'required',
            'price' => 'required|numeric|regex:/^[0-9]*\d?(\.\d{1,2})?$/',
            'color' => 'required',
            'total_price' => 'required|numeric|regex:/^[0-9]*\d?(\.\d{1,2})?$/',
            'interval' => 'required',
            'no_of_services' => 'required',
            'assigne_to' => 'required',      
        ];
    } 

    public function messages()
    {
        return [
            'bill_no.required' => trans('app.Bill no is required.'),
            'date.required' => trans('app.Sales date is required.'),
            'cus_name.required' => trans('app.Customer name is required.'),
            'salesmanname.required' => trans('app.Salesman name is required.'),
            'vehi_bra_name.required' => trans('app.Brand name is required.'),
            'vehicale_name.required' => trans('app.Model name is required.'),
            'price.required' => trans('app.Price is required.'),
            'price.regex'  => trans('app.Price is only numeric data allowed.'),
            'price.numeric' => trans('app.Price is only numeric data.'),
            'color.required' => trans('app.Color is required.'),
            'total_price.required' => trans('app.Total price is required.'),
            'total_price.regex'  => trans('app.After point only two digits allowed.'),
            'total_price.numeric' => trans('app.Total price is only numeric data.'),
            'interval.required' => trans('app.Interval is required.'),
            'no_of_services.required' => trans('app.Number of service field is required.'),
            'assigne_to.required'  => trans('app.Assigned to field is required.'),
        ];
    }
}
