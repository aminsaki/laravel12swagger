<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Symfony\Component\String\u;


class AuthController extends Controller
{


    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="updated_at", type="string"),
     *             @OA\Property(property="created_at", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function register(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password') ,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),

        ]);
        if ($user) {
            return response()->json([
                'status' => true,
                'data' => $user
            ]);
        }
        return response()->json([
            'status' => false,
        ], 404);


    }
       /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login and get access token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Send email and password for login",
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="secret")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful, return token",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOi..."),
     *           )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized — invalid credentials"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($data)) {
            return response()->json([
                'status' => false,
                'message' => 'اطلاعات وارد شده صحیح نیست'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'status' => true,
            'token' => $token,
            'user' => $user
        ]);
    }
//
//    public function logout(Request $request) { … }
//
//    public function me(Request $request) { … }
//
//    public function refreshToken(Request $request) { … }
//
}
