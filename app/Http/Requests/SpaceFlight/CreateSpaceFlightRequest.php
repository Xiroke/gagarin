<?php

namespace App\Http\Requests\SpaceFlight;

use App\Rules\Capitalize;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateSpaceFlightRequest extends FormRequest
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
            "flight_number" => [
                "required", "string", "min:2", "max:255", 'unique:space_flights,flight_number', new Capitalize
            ],
            "destination" => ["required", "string", "min:2", "max:255", new Capitalize],
            "launch_date" => 'required|date',
            "seats_available" => 'required|integer'
        ];
    }
}
