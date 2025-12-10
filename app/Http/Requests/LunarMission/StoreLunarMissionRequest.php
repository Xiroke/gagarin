<?php

namespace App\Http\Requests\LunarMission;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLunarMissionRequest extends FormRequest
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
            'mission.name' => 'required|string|min:2|max:255',

            'mission.launch_details.launch_date' => 'required|date|before:today',
            'mission.launch_details.launch_site.name' => 'required|string|min:2|max:255',
            'mission.launch_details.launch_site.location.latitude' => 'required|numeric|between:-90,90',
            'mission.launch_details.launch_site.location.longitude' => 'required|numeric|between:-180,180',

            'mission.landing_details.landing_date' => 'required|date|before:today',
            'mission.landing_details.landing_site.name' => 'required|string|min:2|max:255',
            'mission.landing_details.landing_site.coordinates.latitude' => 'required|numeric|between:-90,90',
            'mission.landing_details.landing_site.coordinates.longitude' => 'required|numeric|between:-180,180',

            'mission.spacecraft.command_module' => 'required|string|min:2|max:255',
            'mission.spacecraft.lunar_module' => 'required|string|min:2|max:255',
            'mission.spacecraft.crew' => 'required|array',

            'mission.spacecraft.crew.*.name' => 'required|string|min:2|max:255',
            'mission.spacecraft.crew.*.role' => 'required|string|min:2|max:255'
        ];
    }
}

