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
    /**
     * @OA\Get(
     *     path="/api/weather/current",
     *     summary="Obtener el clima actual de una ciudad",
     *     tags={"Weather"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"city"},
     *             @OA\Property(property="city", type="string", example="Madrid"),
     *             @OA\Property(property="lang", type="string", example="es")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa",
     *         @OA\JsonContent(
     *             @OA\Property(property="temperature", type="number", example=22.5),
     *             @OA\Property(property="condition", type="string", example="Soleado"),
     *             @OA\Property(property="wind_kph", type="number", example=10.5),
     *             @OA\Property(property="humidity", type="integer", example=60),
     *             @OA\Property(property="local_time", type="string", example="2025-05-17 12:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al obtener el clima"
     *     )
     * )
     */
    public function current(Request $request)
    {
        $data = $request->validate(['city' => 'required|string', 'lang' => 'string']);
        try {
            $weather = $this->weatherService->getCurrentWeather($data['city'], $data['lang'] ?? '');
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
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'No se pudo obtener el clima.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/weather/history",
     *     summary="Obtener el historial de búsquedas del usuario",
     *     tags={"Weather"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Historial de búsquedas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/SearchHistory"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al obtener el historial"
     *     )
     * )
     */
    public function history(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $history = \Cache::remember("history_{$userId}", 60, function () use ($userId) {
                return SearchHistory::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
            });
            return response()->json($history);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'No se pudo obtener el historial.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/weather/favorite",
     *     summary="Agregar una ciudad a favoritos",
     *     tags={"Weather"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"city"},
     *             @OA\Property(property="city", type="string", example="Madrid")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Favorito agregado",
     *         @OA\JsonContent(ref="#/components/schemas/Favorite")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al agregar favorito"
     *     )
     * )
     */
    public function addFavorite(Request $request)
    {
        $data = $request->validate(['city' => 'required|string']);
        try {
            $exists = Favorite::where('user_id', $request->user()->id)
                ->where('city', $data['city'])
                ->exists();
            if ($exists) {
                return response()->json([
                    'error' => 'La ciudad ' . $data['city'] . ' ya está en favoritos.'
                ], 409);
            }
            $favorite = Favorite::firstOrCreate([
                'user_id' => $request->user()->id,
                'city' => $data['city'],
            ]);
            \Cache::forget("favorites_{$request->user()->id}");
            return response()->json($favorite, 201);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'No se pudo agregar a favoritos.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/weather/favorites",
     *     summary="Obtener las ciudades favoritas del usuario",
     *     tags={"Weather"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de favoritos",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Favorite"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al obtener favoritos"
     *     )
     * )
     */
    public function favorites(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $favorites = \Cache::remember("favorites_{$userId}", 60, function () use ($userId) {
                return Favorite::where('user_id', $userId)->get();
            });
            return response()->json($favorites);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'No se pudo obtener los favoritos.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}