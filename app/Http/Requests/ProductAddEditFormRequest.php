<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddEditFormRequest extends FormRequest
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
            'p_date' => 'required',
            'name' => 'required|regex:/^[(a-zA-Z0-9\s)]+$/u|max:100',          
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'unit' => 'required',            
            'price' => 'required|numeric|regex:/^[0-9]*\d?(\.\d{1,2})?$/',
            'sup_id' => 'required',
            
        ];
    }


    public function messages()
    {
        return [
            'p_date.required' => trans('app.Product date is required.'),

            'name.required' => trans('app.Name is required.'),
            'name.regex'  => trans('app.Name is only alphanumeric and space.'),
            'name.max' => trans('app.Name should not more than 100 character.'),

            //'image.image' => trans('app.The type of the uploaded file should be an image.'),
            'image.mimes' => trans('app.Image must be a file of type: Jpg, Jpeg and Png.'),

            'unit.required' => trans('app.Unit of measurement is required.'),

            'price.required' => trans('app.Price is required.'),            
            'price.numeric' => trans('app.Price is only numeric data allowed.'),
            'price.regex'  => trans('app.Price is only numeric data allowed.'),
            //'price.max' => trans('app.Price field maximum eight digit allowed.'),
            
            'sup_id.required' => trans('app.Supplier is required.'),
        ];

    }
}
