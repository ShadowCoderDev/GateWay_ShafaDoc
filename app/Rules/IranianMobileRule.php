<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IranianMobileRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // check the lenghth of the mobile number
        if (strlen($value) !== 11) {
            $fail('شماره موبایل باید دقیقاً 11 رقم باشد');
            return;
        }

        // check to start with 09
        if (!str_starts_with($value, '09')) {
            $fail('شماره موبایل باید با 09 شروع شود');
            return;
        }

        // check to all must be digits
        if (!ctype_digit($value)) {
            $fail('شماره موبایل فقط باید شامل رقم باشد');
            return;
        }

    }
}
