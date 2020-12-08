<?php

namespace App\Http\Requests;

use App\Enums\WorkPeriodEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;

class CreateJobRequest extends FormRequest
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
            'date'        => Carbon::parse($this->date)->format('Y-m-d'),
            'employee_id' => auth('api_token')->user()->id
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["status" => false, "errors" => $validator->errors()], 422));
    }
}
