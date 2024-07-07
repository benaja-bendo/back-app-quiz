<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/api/v1/auth/login',
        operationId: 'login',
        description: 'Authenticate a user',
        summary: 'Login',
        tags: ['Auth'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 401, description: 'Unauthorized'),
        ],
    )]
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User authenticated',
                'data' => [
                    'user' => auth()->user(),
                    'token' => $token,
                ],
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    #[OA\Post(
        path: '/api/v1/auth/logout',
        operationId: 'logout',
        description: 'Logout a user',
        summary: 'Logout',
        tags: ['Auth'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 401, description: 'Unauthorized'),
        ],
    )]
    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out'
        ], 200);
    }

    #[OA\Post(
        path: '/api/v1/auth/register',
        operationId: 'register',
        description: 'Register a new user',
        summary: 'Register',
        tags: ['Auth'],
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 401, description: 'Unauthorized'),
        ],
    )]
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 201);
    }
}

