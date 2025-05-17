<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/auth/register",
     * operationId="register",
     * summary="Registrar un nuevo usuario",
     * tags={"Auth"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name","email","password","password_confirmation"},
     * @OA\Property(property="name", type="string", example="Juan Pérez"),
     * @OA\Property(property="email", type="string", format="email", example="juan@email.com"),
     * @OA\Property(property="password", type="string", format="password", example="12345678", description="Mínimo 8 caracteres"),
     * @OA\Property(property="password_confirmation", type="string", format="password", example="12345678", description="Debe coincidir con la contraseña")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Usuario registrado exitosamente",
     * @OA\JsonContent(
     * @OA\Property(property="user", ref="#/components/schemas/User"),
     * @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     * @OA\Property(property="token_type", type="string", example="Bearer")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Error de validación de los datos",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Los datos proporcionados no son válidos."),
     * @OA\Property(property="errors", type="object", @OA\AdditionalProperties(type="array", @OA\Items(type="string")))
     * )
     * ),
     * @OA\Response(
     * response=409,
     * description="El correo electrónico ya está registrado",
     * @OA\JsonContent(
     * @OA\Property(property="error", type="string", example="Usuario ya registrado.")
     * )
     * )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * @OA\Post(
     * path="/api/auth/login",
     * operationId="login",
     * summary="Iniciar sesión de usuario",
     * tags={"Auth"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"email","password"},
     * @OA\Property(property="email", type="string", format="email", example="juan@email.com"),
     * @OA\Property(property="password", type="string", format="password", example="12345678")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Inicio de sesión exitoso",
     * @OA\JsonContent(
     * @OA\Property(property="user", ref="#/components/schemas/User"),
     * @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     * @OA\Property(property="token_type", type="string", example="Bearer")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Credenciales inválidas",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Credenciales inválidas")
     * )
     * )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * @OA\Post(
     * path="/api/auth/logout",
     * operationId="logout",
     * summary="Cerrar sesión (revocar todos los tokens del usuario)",
     * tags={"Auth"},
     * security={{"sanctum":{}}},
     * @OA\Response(
     * response=200,
     * description="Cierre de sesión exitoso",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Tokens revocados")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="No autorizado"
     * )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Tokens revocados'], 200);
    }

    /**
     * @OA\Get(
     * path="/api/user",
     * operationId="getUser",
     * summary="Obtener la información del usuario autenticado",
     * tags={"Auth"},
     * security={{"sanctum":{}}},
     * @OA\Response(
     * response=200,
     * description="Información del usuario autenticado",
     * @OA\JsonContent(ref="#/components/schemas/User")
     * ),
     * @OA\Response(
     * response=401,
     * description="No autorizado"
     * )
     * )
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}