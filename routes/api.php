<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Documentation API
|--------------------------------------------------------------------------
|
*/

Route::get('/documentation/json', function (Request $request) {
    $openapi = \OpenApi\Generator::scan(['../app']);
    return response()
        ->json($openapi)
        ->header('Content-Type', 'application/json');
})->name('documentation.json');

/*
|--------------------------------------------------------------------------
| Version 1 API
|--------------------------------------------------------------------------
|
*/
Route::group(['prefix' => 'v1'], function () {
    Route::get('quizzes', [App\Http\Controllers\QuizController::class, 'index']);
    Route::get('quizzes/{id}', [App\Http\Controllers\QuizController::class, 'show']);
    Route::post('quizzes', [App\Http\Controllers\QuizController::class, 'store']);
    Route::put('quizzes/{id}', [App\Http\Controllers\QuizController::class, 'update']);
    Route::delete('quizzes/{id}', [App\Http\Controllers\QuizController::class, 'destroy']);
    Route::get('/generate-quiz', [App\Http\Controllers\QuizController::class, 'generateQuiz']);
    Route::post('auth/login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('auth/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('auth/register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::get('user/{id}/profile', [App\Http\Controllers\UserController::class, 'getProfile']);
    Route::get('users', [App\Http\Controllers\UserController::class, 'allUsers']);

});
