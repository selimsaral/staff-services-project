<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkRequest extends FormRequest
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
            'name'        => 'required',
            'description' => 'required',
            'employee_id' => 'required',
            'city_id'     => 'required',
            'county_id' => 'required',
            'address'     => 'required',
            'date'        => 'required',
            'period'      => 'required',
        ];
    }
}
