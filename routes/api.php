<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/auth/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    // generate fake user
    $user = [
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => '$2y$10$3z3z3z3z3z3z3z3z3z3z',
    ];
    // generate fake token
    $token = 'fake-token';
    $response = [
        'success' => true,
        'message' => 'User authenticated',
        'data' => [
            'user' => $user,
            'token' => $token,
        ],
    ];

    return response()->json($response, 200);
});

Route::post('v1/auth/logout', function (Request $request) {
    $response = [
        'success' => true,
        'message' => 'User logged out',
    ];

    return response()->json($response, 200);
});

Route::post('v1/auth/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
    ]);
    // generate fake user
    $user = [
        'id' => 1,
        'name' => $request->name,
        'email' => $request->email,
        'password' => '$2y$10$3z3z3z3z3z3z3z3z3z3z',
    ];
    $token = 'fake-token';
    $response = [
        'success' => true,
        'message' => 'User registered',
        'data' => [
            'user' => $user,
            'token' => $token,
        ],
    ];
    return response()->json($response, 201);
});

Route::get('/test', function () {
    $yourApiKey = env('OPENAI_API_KEY');
    $client = OpenAI::client($yourApiKey);
    $result = $client->chat()->create([
        'model' => 'gpt-3.5-turbo',
//        'messages' => [
//            ['role' => 'user', 'content' => '
//            Parle moi en français, s\'il te plaît.
//            générer un quiz sur les mathématiques de niveau facile, s\'il vous plaît.
//            structure ta réponse de la maniere qui suit:
//            Q. la question,
//            a. b. c. d. e. comme choix de réponse (plusieurs réponses peuvent être correctes),
//            R. les réponses correctes.(séparées par des virgules)
//            '
//            ],
        'messages' => [
            ['role' => 'user', 'content' => '
            Parle moi en français, s\'il te plaît.
            générer 1 seul quiz sur le javascript de niveau facile, s\'il vous plaît.
            structure ta réponse de la maniere qui suit:
            Q. la question,
            (a. b. c. d. e.) comme choix de réponse (une seule réponse devrait être correcte),
            R. la réponse correcte.
            '
            ],
        ],
    ]);
    $data =$result->choices[0]->message->content;
    return response()->json(['message' => $data], 200);
});
