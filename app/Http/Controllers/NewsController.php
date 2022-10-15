<?php

namespace App\Http\Controllers;

use App\News\EmptyQueryException;
use App\News\NewsApi;
use App\News\NewsDataApi;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{




    private function getNewsClients()
    {
        return
            [
                ['handler' => NewsApi::class, 'api_key' => env('NEWS_API_KEY'), 'is_active'],
                ['handler' => NewsDataApi::class, 'api_key' => 'pub_11986300b17e0485b491b225db76b18eefd03']
            ];
    }
    public function index(Request $request)
    {
        try {

            $query = data_get($request->input(), 'query', '*');
            $input = $request->input();
            $input['q'] = $query;

            $results = [];
            foreach ($this->getNewsClients() as $client){
                try {
                    $client = new $client['handler']($client['api_key']);
                    $results = array_merge($results, $client->query($input));
                }catch (\Exception $e){
                    Log::error($e);
                }

            }

            shuffle($results);
            return $results;

        }catch (EmptyQueryException $e){
            return response(['error' => 'query is missing'], 400);
        }




    }
}
