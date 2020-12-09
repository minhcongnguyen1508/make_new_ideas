<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.homepage');

        $response->assertViewHas('category');
        $response->assertViewHas('notifications');
        $response->assertViewHas('stories');
        $response->assertViewHas('the_most_stories');
        $response->assertViewHas('newest_stories');
    }
}
