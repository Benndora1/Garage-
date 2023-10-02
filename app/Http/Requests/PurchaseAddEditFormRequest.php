<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseAddEditFormRequest extends FormRequest
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
            'p_no' => 'required',
            'p_date' => 'required',
            's_name' => 'required',
            /*'mobile' => 'required',            
            'email' => 'required',
            'address' => 'required',*/
            //'product.Manufacturer_id.*' => 'required',
            //'product.product_id.*' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'p_no.required' => trans('app.Purchase number is required.'),
            'p_date.required' => trans('app.Purchase date is required.'),
            's_name.required' => trans('app.Supplier name is required.'),            
            /*'mobile.required' => trans('app.Mobile number is required.'),
            'email.required' => trans('app.Email is required.'),
            'address.required' => trans('app.Address is required.'),*/
            //'product.Manufacturer_id.*.required' => trans('app.Manufacturer name is required.'),
            //'product.product_id.*.required' => trans('app.Product name is required.'),
        ];

    }
}
