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

    $allSite = [
        "https://www.economie.gouv.fr/rss",
        "https://www.kdnuggets.com/feed",
        "https://www.education.gouv.fr/les-flux-rss-de-l-education-nationale-12644",
        "https://www.01net.com/info/flux-rss/",
        "https://www.01net.com/flux-rss/actualites/jeux-video/",
        "https://www.tech2tech.fr/tag/flux-rss/",
        "https://openai.com/fr-FR/index/rss/",
        "https://blogs.nvidia.com/feed/",
        "https://eduscol.education.fr/rid272/les-ressources-du-site.rss",
        "https://eduscol.education.fr/sites/default/files/rss/rss_rid271_13.xml",
        "https://eduscol.education.fr/rid271/toute-l-actualite-du-site.rss",
    ];

    Route::get('veille/sites', function () use ($allSite) {
        return response()->json([
            'data' => $allSite,
        ], 200);
    });
    Route::get('/veille', function (Request $request) use ($allSite) {

        $params = explode(",", $request->input('sites', ''));

        $array_unic_format = [];
        if (count($params) === 1 && $params[0] === "") {
            $array_unic_format = $allSite;
        } else {
            foreach ($params as $param) {
                if (isset($allSite[$param])) {
                    $array_unic_format[] = $allSite[$param];
                }
            }
        }
        $data = [];
        foreach ($array_unic_format as $key => $url) {
            $f = Vedmant\FeedReader\Facades\FeedReader::read($url);
            $items = $f->get_items();
            foreach ($items as $item) {
                $percentage = fake()->numberBetween(0, 100);
                try {
                    $percentage = getDateIA("Que ta réponse soit juste un nombre entre 0 et 100 qui représente la  fiabilité de l'article
                si l'article traite du domaine de l'éducation, lancement d'une strategie nationnale avec de l'intélligence artificiel pour l'apprentissage
                0 s'il est trop éloingné.
                voici l'article en question: ". $item->get_content()." ". $item->get_date('j F Y | g:i a'));
                } catch (Exception $e) {
                    $percentage = 0;
                }


                $data[] = [
                    'url' => $item->get_permalink(),
                    'title' => $item->get_title(),
                    'content' => $item->get_content(),
                    'link' => $item->get_link(),
                    'date' => $item->get_date('j F Y | g:i a'),
                    'percentage' => $percentage ?? 0,
                ];
            }
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

function getDateIA(string $prompt): ?string
{
    $yourApiKey = env('OPENAI_API_KEY');
    $client = OpenAI::client($yourApiKey);
    $result = $client->chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => $prompt],
        ],
    ]);
    return $result->choices[0]->message->content;
}

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
//    $f = Vedmant\FeedReader\Facades\FeedReader::read('https://www.tech2tech.fr/tag/flux-rss/'); // ok
//        $f = Vedmant\FeedReader\Facades\FeedReader::read('https://www.01net.com/info/flux-rss/'); // ok
