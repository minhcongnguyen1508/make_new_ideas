<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = User::all();
        $result = User::count();
        $this->assertEquals($result, $user->count());
    }

    public function testUpdateSuccess()
    {
        $user = User::where('email', 'admin@test.com')->first();
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('/profile/' . $user->id);
        $params = [
            'username' => 'update'
        ];

        $response = $this->post(route('user.edit', ['id' => $user->id]), $params);
        $response->assertRedirect('/profile/' . $user->id); 
    }

    public function testUnauthenticateUserCannotCreateUser()
    {
        $user = User::where('email', 'admin@test.com')->first();
        $params = [
            'username' => 'update'
        ];

        $response = $this->post(route('user.edit', ['id' => $user->id]), $params);
        $response->assertStatus(302);
        $response->assertRedirect('/signin'); 
    }

    public function testCreateUserRequireName()
    {
        $user = User::where('email', 'admin@test.com')->first();
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('/profile/' . $user->id);

        $params = [
            'username' => null
        ];

        $response = $this->post(route('user.edit', ['id' => $user->id]), $params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('username');
    }

    public function testCreateUserNameMinLength()
    {
        $user = User::where('email', 'admin@test.com')->first();
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('/profile/' . $user->id);

        $params = [
            'username' => '1'
        ];

        $response = $this->post(route('user.edit', ['id' => $user->id]), $params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('username');
    }

    public function testCreateUserAvatarNotImage()
    {
        $user = User::where('email', 'admin@test.com')->first();
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('/profile/' . $user->id);

        $params = [
            'avatar' => 'test'
        ];

        $response = $this->post(route('user.edit', ['id' => $user->id]), $params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('avatar');
    }
}
