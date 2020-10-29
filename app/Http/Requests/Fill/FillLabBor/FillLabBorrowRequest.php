<?php

namespace App\Http\Requests\Fill\FillLabBor;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FillLabBorrowRequest extends FormRequest
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
            'code' => 'required|string',
            'laboratory_id' => 'required|int',
            'course_name' => 'required|string',
            'class_name' => 'required|string',
            'number' => 'required|int',
            'purpose' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'start_class' => 'required|int|between:1,8',
            'end_class' => 'required|int|between:1,8',
        ];
    }
    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(json_fail('参数错误!',$validator->errors()->all(),422)));
    }
}
