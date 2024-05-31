<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;



class UserController extends Controller
{
    /*public function getProfile(Request $request)
    { 
        if(auth()->check()){
            $user = $request->user();
            $response = [
                'success' => true,
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ];
                return response()->json($response);
        } else {

            return ('login');

        }
    }*/

    #[OA\Get(
        path: '/api/v1/user/{id}/profile',
        operationId: 'showUserProfile',
        description: 'My profile',
        summary: 'My Profile',
        tags: ['Profile'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the profile',
                in: 'path',
                required: true,
                allowEmptyValue: false,
                schema: new OA\Schema(type: 'string'),
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Ok'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ],
    )]
    public function getProfile(string $id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Profile not found',
            ], 404);
        }

        return $this->successResponse(
            data: $user,
            message: 'User profile retrieved successfully.',
        );
    }

    public function allUsers(Request $request)
    {
        $users = User::all();
        return response()->json($users);
    }
}
