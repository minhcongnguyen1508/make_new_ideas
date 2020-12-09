<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Generator as Faker;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSignIn()
    {
        $response = $this->get('/signin');

        $response->assertStatus(200);
        $response->assertViewIs('auth.signin')->assertSee('Sign In');
    }

    public function testSignUp()
    {
        $response = $this->get('/signup');

        $response->assertStatus(200);
        $response->assertViewIs('auth.signup')->assertSee('Sign Up');
    }

    public function testCanSignUp()
    {
        $this->assertGuest();

        $response = $this->post('/post-register', [
            'email' => 'admin2@test.com',
            'password' => bcrypt('123456'),
            'username' =>'testcase',
            'role_id' => 1
        ]);

        $response->assertStatus(302)->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function testCanLogin()
    {
        $this->assertGuest();
        $user = User::where('email', 'admin@test.com')->first();

        $this->post('/post-login', [
            'email' => $user->email,
            'password' => '123456',
        ])
            ->assertStatus(302)
            ->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        $user = User::where('email', 'admin@test.com')->first();

        $response = $this->post('/post-login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/signin');
    }
}
