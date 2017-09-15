<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testUserDashboard()
    {
    	$user = factory(User::class)->make();

    	$this->actingAs($user)
    		->get('home')
    		->assertViewIs('home');
    }
}
