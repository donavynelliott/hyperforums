<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserController extends TestCase
{
	use DatabaseMigrations;
	
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
