<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EquipmentBorrowingRequest extends FormRequest
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
            "code"=>'required',
            "borrow_department"=>'required|max:200',
            "borrow_application"=>'required|max:200',
            "destine_start_time"=>'required|date',
            "destine_end_time"=>'required|date|after_or_equal:destine_start_time',
        ];
    }
    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(json_fail(422, '参数错误!', $validator->errors()->all(), 422)));
    }
}
