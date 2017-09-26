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
            ->get('/');

        $response->assertViewIs('home')
            ->assertViewHas('latestAnnouncement')
            ->assertViewHas('recentThreads');
    }

    public function testHomeControllerIndexRedirectsToLoginForAnonUsers()
    {
        $response = $this->get('/');

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
