<?php

namespace App\News;

use GuzzleHttp\Client as HttpClient;

class NewsApi implements NewsApiClientInterface
{

    private $apiKey;

    /**
     * @var HttpClient
     */
    private $client;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new HttpClient();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function query($parameters): array
    {

        $this->validateParameters($parameters);

        $articles = $this->getNews($parameters);

        return $this->extractNewsResults($articles);
    }

    private function buildQueryString($parameters = []): string
    {
        $parameters['apiKey'] = $this->apiKey;

        return http_build_query($parameters);
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
                'link' => $article['url'],
            ];
        }

        return $results;
    }

    /**
     * @param array $parameters
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getNews(array $parameters = [])
    {
        $queryString = $this->buildQueryString($parameters);

        $response = $this->client->get("https://newsapi.org/v2/everything?{$queryString}");

        $response = json_decode($response->getBody()->getContents(), true);

        return data_get($response, 'articles', []);
    }

    private function validateParameters($parameters)
    {

        $query = data_get($parameters, 'q');

        if(empty($query))
            throw new EmptyQueryException();
    }
}
