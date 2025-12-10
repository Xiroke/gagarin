<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LunarMissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,

            'launch_details' => [
                'launch_date' => $this->launch_date,
                'launch_site' => [
                    'name' => $this->launch_site->name,
                    'latitude' => (string) $this->launch_site->latitude,
                    'longitude' => (string) $this->launch_site->longitude,
                ]
            ],

            'landing_details' => [
                'landing_date' => $this->landing_date,
                'landing_site' => [
                    'name' => $this->landing_name,
                    'latitude' => (string) $this->landing_latitude,
                    'longitude' => (string) $this->landing_longitude,
                ]
            ],

            'spacecraft' => [
                "command_module" => $this->command_module,
                "lunar_module" => $this->lunar_module,
                'crew' => $this->crew->cosmonauts->map(function ($member) {
                    return [
                        'name' => $member->name,
                        'role' => $member->role,
                    ];
                })
            ]
        ];
    }
}
