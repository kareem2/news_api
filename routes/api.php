<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/news', function(Request $request){
    $client = new \GuzzleHttp\Client();

    $query = data_get($request->input(), 'query', '*');

    if(empty($query))
        return response(['error' => 'query is missing'], 400);

    $response = $client->get("https://newsapi.org/v2/everything?q=$query&apiKey=d76195c7b3cd45adb21d92a4b71ea26c");

    $response = json_decode($response->getBody()->getContents(), true);

    $articles = data_get($response, 'articles', []);

    $results = [];

    foreach ($articles as $article){
        $results[] = [
            'headline' => $article['title'],
            'link' => $article['url'],

        ];
    }

    return $results;
})->middleware('auth.basic');
