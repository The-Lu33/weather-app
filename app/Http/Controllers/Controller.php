<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Weather API",
 *     description="Documentación de la API del clima",
 *     @OA\Contact(
 *         email=""
 *     )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="Usuario",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Juan Pérez"),
 *     @OA\Property(property="email", type="string", example="juan@email.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-17T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-17T12:00:00Z")
 * )
 * @OA\Schema(
 *     schema="SearchHistory",
 *     type="object",
 *     title="Historial de búsqueda",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="city", type="string", example="Madrid"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-17T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-17T12:00:00Z")
 * )
 * @OA\Schema(
 *     schema="Favorite",
 *     type="object",
 *     title="Favorito",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="city", type="string", example="Madrid"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-17T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-17T12:00:00Z")
 * )
 */


abstract class Controller
{
    //
}
