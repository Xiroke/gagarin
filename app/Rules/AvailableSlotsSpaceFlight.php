<?php

namespace App\Rules;

use App\Models\SpaceFlight;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class AvailableSlotsSpaceFlight implements ValidationRule
{
    /**
     * Есть ли доступные слоты бронирования
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (SpaceFlight::where('flight_number', $value)->first()->seats_available == 0) {
            $fail('All slots of :attribute is booked');
        }
    }
}
