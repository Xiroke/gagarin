<?php

namespace App\Http\Controllers;

use App\Http\Requests\LunarMission\StoreLunarMissionRequest;
use App\Http\Resources\LunarMissionResource;
use App\Http\Resources\SearchLunarMissionResource;
use App\Http\Resources\SearchPersonResource;
use App\Models\Cosmonaut;
use App\Models\Crew;
use App\Models\LaunchSite;
use App\Models\LunarMission;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LunarMissionController extends Controller
{
    /**
     * Все лунные миссии
     */
    public function index()
    {
        $lunarMissions = LunarMission::with('crew')->with('launch_site')->get();

        $data = $lunarMissions->map(function ($item) {
            return ['mission' => new LunarMissionResource($item)];
        });


        return response()->json($data);
    }

    /**
     * Создание лунной миссии
     */
    public function store(StoreLunarMissionRequest $request)
    {
        $data = $request->validated()['mission'];

        $launch_site = LaunchSite::create([
            'name' => data_get($data, 'launch_details.launch_site.name'),
            'latitude' => data_get($data, 'launch_details.launch_site.location.latitude'),
            'longitude' => data_get($data, 'launch_details.launch_site.location.longitude'),
        ]);

        $crew = Crew::create();
        $crew->cosmonauts()->createMany(data_get($data, 'spacecraft.crew', []));


        LunarMission::create([
            'name' => $data['name'],
            'launch_date' => data_get($data, 'launch_details.launch_date'),
            'landing_date' => data_get($data, 'landing_details.landing_date'),
            'landing_name' => data_get($data, 'landing_details.landing_site.name'),
            'landing_latitude' => data_get($data, 'landing_details.landing_site.coordinates.latitude'),
            'landing_longitude' => data_get($data, 'landing_details.landing_site.coordinates.longitude'),
            'command_module' => data_get($data, 'spacecraft.command_module'),
            'lunar_module' => data_get($data, 'spacecraft.lunar_module'),

            'launch_site_id' => $launch_site->id,
            'crew_id' => $crew->id,
        ]);

        $data = [
            "data" => [
                "code" => 201,
                "message" => "Миссия добавлена"
            ]
        ];

        return response()->json($data, 201);
    }

    /**
     * Обновление лунной миссии
     */
    public function update(StoreLunarMissionRequest $request, LunarMission $lunarMission)
    {
        $data = $request->validated()['mission'];

        $missionMapping = [
            'name' => 'name',
            'launch_date' => 'launch_details.launch_date',
            'landing_date' => 'landing_details.landing_date',
            'landing_name' => 'landing_details.landing_site.name',
            'landing_latitude' => 'landing_details.landing_site.coordinates.latitude',
            'landing_longitude' => 'landing_details.landing_site.coordinates.longitude',
            'command_module' => 'spacecraft.command_module',
            'lunar_module' => 'spacecraft.lunar_module',
        ];

        $missionUpdates = [];

        foreach ($missionMapping as $dbCol => $jsonPath) {
            if (Arr::has($data, $jsonPath)) {
                $missionUpdates[$dbCol] = data_get($data, $jsonPath);
            }
        }

        if (!empty($missionUpdates)) {
            $lunarMission->update($missionUpdates);
        }

        $launchSiteMapping = [
            'name' => 'launch_details.launch_site.name',
            'latitude' => 'launch_details.launch_site.location.latitude',
            'longitude' => 'launch_details.launch_site.location.longitude',
        ];

        $launchSiteUpdates = [];
        foreach ($launchSiteMapping as $dbCol => $jsonPath) {
            if (Arr::has($data, $jsonPath)) {
                $launchSiteUpdates[$dbCol] = data_get($data, $jsonPath);
            }
        }

        if (!empty($launchSiteUpdates)) {
            $lunarMission->launch_site()->update($launchSiteUpdates);
        }

        if (Arr::has($data, 'spaceship.crew')) {
            $lunarMission->crew->cosmonauts()->delete();
            $lunarMission->crew->cosmonauts()->createMany(data_get($data, 'spaceship.crew'));
        }

        $data = [
            "data" => [
                "code" => 200,
                "message" => "Миссия обновлена"
            ]
        ];

        return response()->json($data);
    }

    /**
     * Удаление.
     */
    public function destroy(LunarMission $lunarMission)
    {
        $lunarMission->delete();
        return response()->noContent();
    }

    /**
     * Поиск по миссиям и пилотам
     */
    public function search(Request $request)
    {
        $query = $request->query('query');
        $missions = LunarMission::whereLike('name', '%'.$query.'%')->get();
        $pilots = Cosmonaut::whereLike('role', 'Пилот%')->whereLike('name', '%'.$query.'%')->get()->unique('name');

        $data = [
            'data' => array_merge(
                SearchLunarMissionResource::collection($missions)->resolve(),
                SearchPersonResource::collection($pilots)->resolve()
            )
        ];
        return response()->json($data);
    }
}
