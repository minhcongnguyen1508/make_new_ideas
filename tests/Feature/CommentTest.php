<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateCommentSuccess()
    {
        $user = User::where('email', 'admin@test.com')->first();
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('/story/1');

        $response = $this->post('/comment/1', [
            'content' => 'test comment',
            'post_id' => 1,
            'user_id' => $user->id,
            'type' => 1,
            'status' => 1
        ]);

        $response->assertRedirect('/story/1');
        $this->assertAuthenticated();
    }

    public function testLike()
    {
        
    }
}
