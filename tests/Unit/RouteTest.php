<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RouteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGet()
    {
        $response = $this->get("/");
        $response->assertStatus(200);
    }

    public function testPost()
    {
        $response = $this->post("/comment");
        $response->assertStatus(404);
    }

}
