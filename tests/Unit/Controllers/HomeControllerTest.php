<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class HomeController extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->announcement = factory('App\Announcement')->create();
        $this->user = factory('App\User')->create();
    }
    public function testHomeControllerIndexForAuthUser()
    {
        $response = $this->actingAs($this->user)
            ->get('/home');

        $response->assertViewIs('home');
    }

    public function testHomeControllerIndexRedirectsToLoginForAnonUsers()
    {
        $response = $this->get('/home');

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
