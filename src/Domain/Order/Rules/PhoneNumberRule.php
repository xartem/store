<?php

namespace Domain\Order\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumberRule implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return is_numeric($value);
    }

    public function message()
    {
        return 'The validation error message.';
    }
}
