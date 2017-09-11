<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    public function testUserDashboard()
    {
    	$user = factory(User::class)->make();

    	$this->actingAs($user)
    		->get('home')
    		->assertViewIs('home');
    }
}
