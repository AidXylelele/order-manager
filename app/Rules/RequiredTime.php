<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RequiredTime implements Rule
{

    public function passes($attribute, $value)
    {
        $pattern = '/^([0-9]+|\d{2,}):[0-5][0-9]$/';

        return preg_match($pattern, $value) === 1;
    }

    public function message()
    {
        return 'Use correct format of the time (hours:minutes).';
    }
}