<?php

namespace Tests\Unit;

use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_route_1()
    {
        $response=$this->get('/');
        $response->assertStatus(200);
    }

    public function test_route_register()
    {
        $response=$this->get('/register');
        $response->assertStatus(200);
    }

    public function test_route_login()
    {
        $response=$this->get('/login');
        $response->assertStatus(200);
    }

    public function test_route_home()
    {
        $response=$this->get('/home');
        $response->assertStatus(302);
    }

    public function test_route_invalid_page()
    {
        $response = $this->get('/anyInvalid');
        $response->assertStatus(404);
    }
    
}