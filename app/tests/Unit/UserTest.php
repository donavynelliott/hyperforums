<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserDashboard()
    {
    	$user = factory(\App\User::class)->create();

    	$this->actingAs($user)
    		->get('home')
    		->assertViewIs('home');
    }
}
