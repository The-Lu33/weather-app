<?php

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\SearchHistory;
use App\Service\WeatherService;
use Illuminate\Http\Request;

class WeatherContoller extends Controller
{
    private $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * @OA\Get(
     *     path="/api/weather/current",
     *     operationId="getCurrentWeather",
     *     summary="Obtener el clima actual de una ciudad",
     *     tags={"Weather"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="city",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", example="London"),
     *         description="Nombre de la ciudad para la cual se desea obtener el clima actual."
     *     ),
     *     @OA\Parameter(
     *         name="lang",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", example="es"),
     *         description="Código del idioma para la respuesta (opcional)."
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Clima actual obtenido exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="temperature", type="number", format="float", example=22.5, description="Temperatura actual en grados Celsius."),
     *             @OA\Property(property="condition", type="string", example="Soleado", description="Descripción textual de la condición climática."),
     *             @OA\Property(property="wind_kph", type="number", format="float", example=10.5, description="Velocidad del viento en kilómetros por hora."),
     *             @OA\Property(property="humidity", type="integer", example=60, description="Porcentaje de humedad."),
     *             @OA\Property(property="local_time", type="string", example="2025-05-17 15:00", description="Hora local de la ciudad.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud inválida."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor al obtener el clima."
     *     )
     * )
     */
    public function current(Request $request)
    {
        $data = $request->validate(['city' => 'required|string', 'lang' => 'nullable|string']);
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
     *     operationId="getSearchHistory",
     *     summary="Obtener el historial de las últimas 10 búsquedas del usuario autenticado.",
     *     tags={"Weather"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Historial de búsquedas obtenido exitosamente.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="city", type="string", example="London"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-17T14:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-17T14:00:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor al obtener el historial."
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
     *     operationId="addCityToFavorites",
     *     summary="Agregar una ciudad a la lista de favoritos del usuario.",
     *     tags={"Weather"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"city"},
     *             @OA\Property(property="city", type="string", example="Paris", description="Nombre de la ciudad a agregar a favoritos.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ciudad agregada a favoritos exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="city", type="string", example="Paris"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-17T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-17T14:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="La ciudad ya existe en la lista de favoritos."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación de la solicitud."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor al agregar a favoritos."
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
     *     operationId="getUserFavorites",
     *     summary="Obtener la lista de ciudades favoritas del usuario autenticado.",
     *     tags={"Weather"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de favoritos obtenida exitosamente.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="city", type="string", example="Paris"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-17T14:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-17T14:00:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor al obtener los favoritos."
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