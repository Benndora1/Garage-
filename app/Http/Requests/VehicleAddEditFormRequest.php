<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleAddEditFormRequest extends FormRequest
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
            'vehical_id' => 'required',
            'vehicabrand' => 'required',
            'fueltype' => 'required',
            'modelname' => 'required',
            'price' => 'required|numeric|regex:/^[0-9]*\d?(\.\d{1,2})?$/',
            'image' => 'nullable|mimes:jpg,png,jpeg',
        ];
    }

    public function messages()
    {
        return [
            'vehical_id.required' => trans('app.Vehicle type is required.'),
            'vehicabrand.required' => trans('app.Vehicle brand is required.'),
            'fueltype.required' => trans('app.Fuel type is required.'),
            'modelname.required' => trans('app.Model name is required.'),
            'price.required' => trans('app.Price is required.'),
            'price.regex'  => trans('app.Price is only numeric data allowed.'),
            'price.numeric' => trans('app.Price is only numeric data allowed.'),

            'image.mimes' => trans('app.Image must be a file of type: Jpg, Jpeg and Png.'),
            //'image.mimes' => trans('app.Image must be a file of type: Jpg, Jpeg and Png.'),
        ];

    }

}
