<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRouteGet()
    {

        $response = $this->get('/');
        $response->assertStatus(200);

        $response2 = $this->get('/teste');
        $response2->assertStatus(404);
    }
}
