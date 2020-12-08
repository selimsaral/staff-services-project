<?php

namespace App\Http\Requests\Admin;

use App\Enums\WorkPeriodEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class JobRequest extends FormRequest
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
            'county_id'   => 'required',
            'address'     => 'required',
            'date'        => 'required',
            'period'      => 'required',
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'started_at'  => WorkPeriodEnum::periods[$this->period]['start'],
            'finished_at' => WorkPeriodEnum::periods[$this->period]['end'],
            'date'        => Carbon::parse($this->date)->format('Y-m-d')
        ]);
    }

}
