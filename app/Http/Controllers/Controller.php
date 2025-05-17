<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Weather API",
 *     description="API para obtener información del clima actual, historial de búsquedas y gestionar ciudades favoritas.",
 *     @OA\Contact(
 *         email="tu_email@example.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="Servidor API principal"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Token de autenticación Bearer"
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="Usuario",
 *     description="Representa la información de un usuario autenticado.",
 *     @OA\Property(property="id", type="integer", example=1, description="ID único del usuario."),
 *     @OA\Property(property="name", type="string", example="Juan Pérez", description="Nombre completo del usuario."),
 *     @OA\Property(property="email", type="string", format="email", example="juan@email.com", description="Correo electrónico del usuario."),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-17T12:00:00.000000Z", description="Fecha y hora de creación del usuario."),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-17T12:00:00.000000Z", description="Fecha y hora de última actualización del usuario.")
 * )
 *
 * @OA\Schema(
 *     schema="SearchHistory",
 *     type="object",
 *     title="Historial de búsqueda",
 *     description="Representa una búsqueda de clima realizada por un usuario.",
 *     @OA\Property(property="id", type="integer", example=1, description="ID único del registro de búsqueda."),
 *     @OA\Property(property="user_id", type="integer", example=2, description="ID del usuario que realizó la búsqueda."),
 *     @OA\Property(property="city", type="string", example="Madrid", description="Nombre de la ciudad buscada."),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-17T12:00:00.000000Z", description="Fecha y hora en que se realizó la búsqueda."),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-17T12:00:00.000000Z", description="Fecha y hora de última actualización del registro.")
 * )
 *
 * @OA\Schema(
 *     schema="Favorite",
 *     type="object",
 *     title="Ciudad favorita",
 *     description="Representa una ciudad marcada como favorita por un usuario.",
 *     @OA\Property(property="id", type="integer", example=1, description="ID único del registro de favorito."),
 *     @OA\Property(property="user_id", type="integer", example=2, description="ID del usuario que agregó la ciudad a favoritos."),
 *     @OA\Property(property="city", type="string", example="Madrid", description="Nombre de la ciudad favorita."),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-17T12:00:00.000000Z", description="Fecha y hora en que se agregó la ciudad a favoritos."),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-17T12:00:00.000000Z", description="Fecha y hora de última actualización del registro.")
 * )
 */
abstract class Controller
{
    //
}