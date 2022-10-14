<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_should_be_authenticated_before_use_the_api()
    {
        $response = $this->get('/api/news');

        $response->assertStatus(401);
    }


    /** @test */
    public function test_get_news_feed()
    {
        $response = $this->be($this->user)->get('/api/news');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_should_return_a_valid_response()
    {

        $response = $this->be($this->user)->get('/api/news');

        $response->assertJsonStructure([['headline', 'link']]);
    }

    /** @test */
    public function it_should_return_error_if_the_query_is_empty()
    {
        $response = $this->be($this->user)->get('/api/news?query=');

        $response
            ->assertStatus(400)
            ->assertJson(['error' => 'query is missing']);
    }


}
