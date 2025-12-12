<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Capitalize implements ValidationRule
{
    /**
     * Первая буква - заглавная
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $firstChar = mb_substr($value, 0, 1);

        if (mb_strtoupper($firstChar) != $firstChar) {
            $fail('In :attribute the first char must be in uppercase');
        }
    }
}
