<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/category/1');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.category_posts');

        $response->assertViewHas('newest_stories');
        $response->assertViewHas('notifications');
        $response->assertViewHas('stories');
        $response->assertViewHas('category_name');
        $response->assertViewHas('category');
    }
}
