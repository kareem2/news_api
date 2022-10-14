<?php

namespace App\Http\Controllers;

use App\News\EmptyQueryException;
use App\News\NewsApi;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index(Request $request)
    {
        try {
            $apiClient = new NewsApi(env('NEWS_API_KEY'));

            $query = data_get($request->input(), 'query', '*');
            $input = $request->input();
            $input['q'] = $query;

            return $apiClient->query($input);

        }catch (EmptyQueryException $e){
            return response(['error' => 'query is missing'], 400);
        }




    }
}
