<?php

namespace App\News;

use GuzzleHttp\Client as HttpClient;

class NewsDataApi implements NewsApiClientInterface
{

    private $apiKey;

    private $client;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new HttpClient();

    }

    public function query($parameters)
    {
        $response = $this->client->get("https://newsdata.io/api/1/news?apikey={$this->apiKey}&q={$parameters['q']}");

        $response = json_decode($response->getBody()->getContents(), true);

        return $this->extractNewsResults($response['results']);
    }

    /**
     * @param $articles
     * @return array
     */
    public function extractNewsResults($articles): array
    {
        $results = [];

        foreach ($articles as $article) {
            $results[] = [
                'headline' => $article['title'],
                'link' => $article['link'],
                'source' => 'newsdataapi'
            ];
        }

        return $results;
    }
}
