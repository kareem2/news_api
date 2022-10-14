<?php

namespace Tests\Feature;

use App\News\EmptyQueryException;
use App\News\NewsApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsApiTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_should_raise_exception_if_the_query_is_empty()
    {
        $newsApiClient = new NewsApi('123');

        $this->expectException('\App\News\EmptyQueryException');

        $newsApiClient->query(['q' => null]);


    }


}
