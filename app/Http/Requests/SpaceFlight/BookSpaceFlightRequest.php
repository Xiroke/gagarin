<?php

namespace App\Http\Requests\SpaceFlight;

use App\Rules\AvailableSlotsSpaceFlight;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BookSpaceFlightRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'flight_number' => ['required', 'exists:space_flights,flight_number', new AvailableSlotsSpaceFlight]
        ];
    }
}
