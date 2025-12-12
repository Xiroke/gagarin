<?php

namespace App\Http\Controllers;

use App\Http\Resources\FlightResource;
use App\Models\LunarMission;

class FlightController extends Controller
{
    /**
     * Получение полета
     */
    public function index()
    {
        $flight = LunarMission::with('crew')->with('launch_site')->firstOrFail();

        $data = ['data' => new FlightResource($flight)];

        return response()->json($data);
    }
}
