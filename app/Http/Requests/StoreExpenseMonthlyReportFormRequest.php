<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseMonthlyReportFormRequest extends FormRequest
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
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'start_date.required' => trans('app.Start date is required.'),
            'end_date.required' => trans('app.End date is required.'),
        ];

    }
}
