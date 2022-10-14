<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index(Request $request)
    {
        $client = new HttpClient();

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
    }
}
