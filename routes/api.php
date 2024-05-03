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

Route::post('/generate-quiz', function (Request $request) {
    $skill = $request->input('skill');
    $level = $request->input('level');


    return response()->json(['skill' => $skill, 'level' => $level, 'message' => 'Quiz généré avec succès'], 200);
});

Route::get('/test', function () {
    $yourApiKey = env('OPENAI_API_KEY');
    $client = OpenAI::client($yourApiKey);
    $result = $client->chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => ' 
            je veux que tu me generes  en francais 
            un  seul quiz sur le  $skill de niveau  $niveau , 
            en structurant ta réponse de la maniere qui suit:
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

Route::get('v1/quiz', function (Request $request) {
    $quizList = [
        [
            'id' => 1,
            'title' => 'Films des années 80',
            'minutes' => '20',
            'level' => 'Difficile',
            'answer' => 'blanc',
        ],
        [
            'id' => 2,
            'title' => 'Capitales mondiales',
            'min' => '5',
            'level' => 'Facile',
            'answer' => 'Paris',
        ],
        [
            'id' => 3,
            'title' => 'Personnages de dessins animés',
            'min' => '7',
            'level' => 'Facile',
            'answer' => '4',
        ],
        [
            'id' => 4,
            'title' => 'Énigmes mathématiques',
            'min' => '20',
            'level' => 'Difficile',
            'answer' => 'blanc',
        ],
        [
            'id' => 5,
            'title' => 'Voiture de sport',
            'min' => '10',
            'level' => 'Moyen',
            'answer' => 'Paris',
        ],
        [
            'id' => 6,
            'title' => 'Cuisine internationale',
            'min' => '18',
            'level' => 'Difficile',
            'answer' => '4',
        ],
    ];

    return response()->json($quizList, 200);
});
