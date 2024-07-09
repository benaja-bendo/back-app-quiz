<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Documentation API
|--------------------------------------------------------------------------
|
*/

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

    Route::get('/veille', function () {
//    Méthode 1
//    $result = Process::run('node ../app.js');
//    dd($result->output());

//    Méthode 2
//    $client = \Symfony\Component\Panther\Client::createChromeClient();
//    $crawler = $client->request('GET', 'https://www.lesnumeriques.com/souris/logi tech-g309-lightspeed-p75280/test.html');
//
//    dd($crawler->html());
//
//        // TODO ... Interactions avec la page (clics, etc.) ...
//
//    $articles = $crawler->filter('article.votre_classe_article')->each(function ($node) {
//        // TODO... Extraction des données ...
//    });

//    Méthode 3
//    $f = Vedmant\FeedReader\Facades\FeedReader::read('https://www.linforme.com/rss/all_headline.xml'); // ok
//    $f = Vedmant\FeedReader\Facades\FeedReader::read('https://news.google.com/news/rss');
//    $f = Vedmant\FeedReader\Facades\FeedReader::read('https://www.frandroid.com/tag/flux-rss'); // ok
    $f = Vedmant\FeedReader\Facades\FeedReader::read('https://www.tech2tech.fr/tag/flux-rss/'); // ok
//        $f = Vedmant\FeedReader\Facades\FeedReader::read('https://www.01net.com/info/flux-rss/'); // ok
        $items = $f->get_items();
        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'url' => $item->get_permalink(), // 'https://www.01net.com/actualites/le-jeu-video-est-il-un-sport-comme-les-autres-2090137.html'
                'title' => $item->get_title(),
                'content' => $item->get_content(),
                'link' => $item->get_link(),
                'date' => $item->get_date('j F Y | g:i a'),
            ];
        }

        return response()->json([
            'data' => $data,
        ], 200);
    });

    Route::get('/documentation/json', function (Request $request) {
        $openapi = \OpenApi\Generator::scan(['../app']);
        return response()
            ->json($openapi)
            ->header('Content-Type', 'application/json');
    })->name('documentation.json');

});
