<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserController extends TestCase
{
	use RefreshDatabase;
	public function setUp()
	{
		parent::setUp();
		$this->user = factory('App\User')->create();
	}

	public function testUserControllerShow()
	{
		$user = $this->user;
		$response = $this->get('profile/' . $user->id);

		$response->assertViewIs('profile')
				->assertViewHas('user');
	}
}
