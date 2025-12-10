<?php

namespace App\Http\Requests\LunarMission;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLunarMissionResource extends FormRequest
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
            'mission.name' => 'nullable|string|min:2|max:255',

            'mission.launch_details.launch_date' => 'nullable|date|before:today',
            'mission.launch_details.launch_site.name' => 'nullable|string|min:2|max:255',
            'mission.launch_details.launch_site.location.latitude' => 'nullable|numeric|between:-90,90',
            'mission.launch_details.launch_site.location.longitude' => 'nullable|numeric|between:-180,180',

            'mission.landing_details.landing_date' => 'nullable|date|before:today',
            'mission.landing_details.landing_site.name' => 'nullable|string|min:2|max:255',
            'mission.landing_details.landing_site.coordinates.latitude' => 'nullable|numeric|between:-90,90',
            'mission.landing_details.landing_site.coordinates.longitude' => 'nullable|numeric|between:-180,180',

            'mission.spacecraft.command_module' => 'nullable|string|min:2|max:255',
            'mission.spacecraft.lunar_module' => 'nullable|string|min:2|max:255',
            'mission.spacecraft.crew' => 'nullable|array',

            'mission.spacecraft.crew.*.name' => 'nullable|string|min:2|max:255',
            'mission.spacecraft.crew.*.role' => 'nullable|string|min:2|max:255'
        ];
    }
}
