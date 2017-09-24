<?php

namespace Tests\Feature;

use App\Forum;
use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $user = factory('App\User')->create();
        $this->forum = factory('App\Forum')->create();
        $this->thread = factory('App\Thread')->create([
            'forum_id' => $this->forum->id,
        ]);
        $this->reply = factory('App\Reply')->create([
            'forum_id' => $this->forum->id,
            'thread_id' => $this->thread->id,
        ]);

        $this->actingAs($user);
    }

    public function testThreadCanAddReply()
    {
        $thread = $this->thread;
        $reply = [
            'forum_id' => $this->forum->id,
            'thread_Id' => $this->thread->id,
            'user_id' => $this->thread->user->id,
            'body' => 'This is a new reply',
        ];

        $thread->addReply($reply);

        $this->assertDatabaseHas('replies', $reply);
    }

    public function testThreadBelongsToForum()
    {
        $this->assertTrue($this->thread->forum instanceof Forum);
    }

    public function testThreadBelongsToUser()
    {
        $this->assertTrue($this->thread->user instanceof User);
    }

    public function testThreadCanFindReplies()
    {
        $findReply = $this
            ->thread
            ->replies()
            ->find($this->reply->id);
        $this->assertTrue($findReply instanceof Reply);
    }
}
