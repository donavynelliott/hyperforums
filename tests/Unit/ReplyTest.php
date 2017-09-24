<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->reply = factory('App\Reply')->create();
        $this->user = $this->reply->user;
        $this->thread = $this->reply->thread;
        $this->forum = $this->thread->forum;
    }

    public function testAuthUserCanSubmitReplyToThread()
    {
        $forum = $this->forum;
        $thread = $this->thread;
        $user = $this->user;

        $reply = [
            'body' => 'testAuthUserCanSubmitReplyToThread',
        ];

        $response = $this->actingAs($user)
            ->post('/forum/' . $forum->id . '/threads/' . $thread->id . '/replies', $reply);

        $this->assertDatabaseHas('replies', $reply);
    }
}
