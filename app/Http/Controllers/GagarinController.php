<?php

namespace App\Http\Controllers;

use App\Models\LunarMission;

class GagarinController extends Controller
{
    /**
     * Информауия о гагарине
     */
    public function index(LunarMission $lunarMission)
    {
        $path = public_path('/gagarin.json');

        $jsonData = file_get_contents($path);

        $data = json_decode($jsonData, true);

        return response()->json($data);
    }
}
