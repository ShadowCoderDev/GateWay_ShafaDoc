<?php

namespace App\Http\requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ApiLoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'mobile' => [
                'required',
                'string',
                'max:11',
                'min:11',
                'regex:/^09[0-9]{9}$/'
            ],
            'password' => [
                'required',
                'string',
                'min:6'
            ]
        ];
    }


    public function messages(): array
    {
        return [
            'mobile.required' => 'شماره موبایل الزامی است',
            'mobile.regex' => 'فرمت شماره موبایل صحیح نیست',
            'mobile.max' => 'شماره موبایل باید 11 رقم باشد',
            'mobile.min' => 'شماره موبایل باید 11 رقم باشد',
            'password.required' => 'رمز عبور الزامی است',
            'password.min' => 'رمز عبور باید حداقل 6 کاراکتر باشد'
        ];
    }


    public function attributes(): array
    {
        return [
            'mobile' => 'شماره موبایل',
            'password' => 'رمز عبور'
        ];
    }
}
