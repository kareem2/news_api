<?php

namespace Tests\Feature;

use App\News\EmptyQueryException;
use App\News\NewsApi;
use App\News\NewsDataApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class NewsApiSourcesTest extends TestCase
{
    use RefreshDatabase;



    /** @test */
    public function test_news_api_should_be_running()
    {

        $client = new NewsApi(env('NEWS_API_KEY'));
        $results = $client->query(['q' => '*']);

        $this->assertIsArray($results);

    }

    /** @test */
    public function test_newsdata_api_should_be_running()
    {

        $client = new NewsDataApi('pub_11986300b17e0485b491b225db76b18eefd03');
        $results = $client->query(['q' => '*']);

        $this->assertIsArray($results);

    }

}
