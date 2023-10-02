<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreObservationLibraryAddFormRequest extends FormRequest
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
            'veh_name.*' => 'required',
            'checkpoint_name1' => 'required',
            'checkpoint' => 'required|max:30|regex:/^[a-zA-Z][a-zA-Z0-9\s\.\@\-\_]*$/',
        ];
    }

    public function messages()
    {
        return [
            'veh_name.required' => trans('app.Vehicle name is required.'),
            'checkpoint_name1.required'  => trans('app.Checkpoint category is required.'),            
            'checkpoint.required' => trans('app.Check point is required.'),
            'checkpoint.regex'  => trans('app.Start should be alphabets only after supports alphanumeric, space, dot, @, _, and - are allowed.'),
            'checkpoint.max' => trans('app.Check point should not more than 30 character.'),
        ];

    }
}
