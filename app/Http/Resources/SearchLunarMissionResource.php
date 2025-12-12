<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchLunarMissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'Миссия',
            'name' => $this->name,
            'launch_date' => $this->launch_date,
            'landing_date' => $this->landing_date,
            'crew' => $this->crew->cosmonauts->map(function ($member) {
                return [
                    'name' => $member->name,
                    'role' => $member->role,
                ];
            }),
            'landing_site' => $this->landing_name,
        ];
    }
}
