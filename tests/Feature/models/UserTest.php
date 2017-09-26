<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->announcement = factory('App\Announcement')->create();
        $this->user = factory('App\User')->create();
    }

    public function testUserDashboard()
    {
        $response = $this->actingAs($this->user)
            ->get('/');

        $response->assertStatus(200)
            ->assertViewIs('home');
    }
}
