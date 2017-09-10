<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeController extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->user = factory('App\User')->create();
	}
	public function testHomeControllerIndexForAuthUser()
	{	
		$user = $this->user;
		$response = $this->actingAs($user)
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
