<?php

namespace Tests\Feature;

use App\News\EmptyQueryException;
use App\News\NewsApi;
use App\News\NewsDataApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsDataApiTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_should_raise_exception_if_the_query_is_empty()
    {
        $newsApiClient = new NewsDataApi('pub_11986300b17e0485b491b225db76b18eefd03');

        $results = $newsApiClient->query(['query' => 'php']);

        $this->assertIsArray($results);
    }


}
