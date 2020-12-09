<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factory;

class StoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = User::where('email', 'admin@test.com')->first();

        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->get('/story/1');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.story');

        $response->assertViewHas('story');
        $response->assertViewHas('name');
        $response->assertViewHas('comments');
        $response->assertViewHas('notifications');
        $response->assertViewHas('newest_stories');

        // $story = $response->getOriginalContent()->getData()['story'];
        // $this->assertInstanceOf(Post::class, $story);
    }
}
