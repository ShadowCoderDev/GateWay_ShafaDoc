<?php

namespace App\Http\requests\Api\V1;

use App\Rules\IranianMobileRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiAdminRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'mobile' => [
                'required',
                'string',
                'unique:users,mobile',
                new IranianMobileRule()
            ],
            'national_code' => [
                'required',
                'string',
                'unique:users,national_code',
                'regex:/^[0-9]{10}$/',
                'size:10'
            ],
            'password' => 'required|string|min:6|confirmed',
        ];
    }


    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'نام الزامی است',
            'name.string' => 'نام باید رشته باشد',
            'name.max' => 'نام نباید بیش از 255 کاراکتر باشد',

            'email.required' => 'ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل معتبر نیست',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است',
            'email.max' => 'ایمیل نباید بیش از 255 کاراکتر باشد',

            'mobile.required' => 'شماره موبایل الزامی است',
            'mobile.string' => 'شماره موبایل باید رشته باشد',
            'mobile.unique' => 'این شماره موبایل قبلاً ثبت شده است',

            'national_code.required' => 'کد ملی الزامی است',
            'national_code.string' => 'کد ملی باید رشته باشد',
            'national_code.unique' => 'این کد ملی قبلاً ثبت شده است',
            'national_code.regex' => 'کد ملی باید دقیقاً 10 رقم باشد',
            'national_code.size' => 'کد ملی باید دقیقاً 10 رقم باشد',

            'password.required' => 'رمز عبور الزامی است',
            'password.string' => 'رمز عبور باید رشته باشد',
            'password.min' => 'رمز عبور باید حداقل 6 کاراکتر باشد',
            'password.confirmed' => 'تایید رمز عبور مطابقت ندارد',
        ];
    }


    /**
     * Handle a failed validation attempt
     */
    protected function failedValidation(Validator $validator)
    {
        $response = [
            'success' => false,
            'message' => 'اطلاعات وارد شده معتبر نیست',
            'status_code' => 422,
            'errors' => $validator->errors()
        ];

        throw new HttpResponseException(
            response()->json($response, 422)
        );
    }
}
