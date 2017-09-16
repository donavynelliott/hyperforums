<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
    	parent::setUp();
    	$this->user = factory('App\User')->create();
    }
    
    public function testUserDashboard()
    {
    	$user = $this->user;

    	$this->actingAs($user)
    		->get('home')
    		->assertViewIs('home');
    }
}
