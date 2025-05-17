<?php

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;

use App\Models\Favorite;
use App\Models\SearchHistory;
use App\Service\WeatherService;
use Illuminate\Http\Request;


class WeatherContoller extends Controller
{
    // agregar service 
    private $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }


    public function current(Request $request)
    {
        $data = $request->validate(['city' => 'required|string']);
        // dd($data);
        $weather = $this->weatherService->getCurrentWeather($data['city']);

        // Guardar en historial
        SearchHistory::create([
            'user_id' => $request->user()->id,
            'city' => $data['city'],
        ]);

        return response()->json([
            'temperature' => $weather->temperature,
            'condition' => $weather->condition,
            'wind_kph' => $weather->wind,
            'humidity' => $weather->humidity,
            'local_time' => $weather->localTime,
        ], 200);
    }
    public function history(Request $request)
    {
        $history = SearchHistory::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json($history);
    }

    public function addFavorite(Request $request)
    {
        $data = $request->validate(['city' => 'required|string']);

        $favorite = Favorite::firstOrCreate([
            'user_id' => $request->user()->id,
            'city' => $data['city'],
        ]);

        return response()->json($favorite, 201);
    }
}