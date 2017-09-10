<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadRepliesTest extends TestCase
{
	use RefreshDatabase;

	public function setUp()
	{	
		parent::setUp();
		$this->thread = factory(Thread::class)->create();
	}

	public function testCreatingRepliesToAThread()
	{
		$thread = $this->thread;

		$reply = array(
			'user_id' => 1,
			'body' => 'testCreatingRepliesToAThread',
		);

		$thread->addReply($reply);
		$this->assertDatabaseHas('replies', $reply);
	}
}
