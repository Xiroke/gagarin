<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpaceFlight\BookSpaceFlightRequest;
use App\Http\Requests\SpaceFlight\CreateSpaceFlightRequest;
use App\Models\SpaceFlight;

class SpaceFlightController extends Controller
{
    /**
     * Список рейсов
     */
    public function index()
    {
        $spaceFlights = SpaceFlight::where('seats_available', '>', '0')->get();

        $data = [
            'data' => $spaceFlights
        ];

        return response()->json($data);
    }

    /**
     * Создание рейса
     */
    public function store(CreateSpaceFlightRequest $request)
    {
        $validated = $request->validated();
        SpaceFlight::create($validated);

        $data = [
            'data' => [
                'code' => 201,
                'message' => 'Космический полет создан',
            ]
        ];

        return response()->json($data, 201);
    }

    /**
     * Бронирование рейса
     */
    public function book(BookSpaceFlightRequest $request)
    {
        $validated = $request->validated();

        $spaceFlight = SpaceFlight::where('flight_number', $validated['flight_number'])->first();
        $spaceFlight->seats_available = $spaceFlight->seats_available - 1;
        $spaceFlight->save();

        $data = [
            "data" => [
                "code" => 201,
                "message" => "Рейс забронирован"
            ]
        ];

        return response()->json($data, 201);
    }
}
