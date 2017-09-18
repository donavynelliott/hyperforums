<?php

namespace Tests\Unit;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadRepliesTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    public function testAddReplyToThread()
    {
        $thread = $this->thread;

        $reply = array(
            'user_id' => 1,
            'forum_id' => $thread->forum->id,
            'body' => 'testCreatingRepliesToAThread',
        );

        $thread->addReply($reply);
        $this->assertDatabaseHas('replies', $reply);
    }
}
