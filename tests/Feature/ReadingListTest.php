<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Dusk\Browser;

class ReadingListTest extends TestCase
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
                         ->get('/reading-list');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.reading-list');

        $response->assertViewHas('story');
    }

}
