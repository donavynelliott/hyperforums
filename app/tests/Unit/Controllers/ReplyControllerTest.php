<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyController extends TestCase
{
	use RefreshDatabase;

	public function setUp()
	{
		parent::setUp();
		$this->user = factory('App\User')->create();
		$this->thread = factory('App\Thread')->create();
		$this->reply = factory('App\Reply')->create();
	}

	public function testReplyControllerStore()
	{
		$user = $this->user;
		$thread = $this->thread;
		$reply = array(
			'user_id' => $user->id,
			'thread_id' => $thread->id,
			'body' => 'testReplyControllerStore'
		);

		$response = $this->actingAs($user)
					->post('/forum/' . $thread->forum->id . '/threads/' . $thread->id . '/replies', $reply);

		$response->assertStatus(302);
	}
}
