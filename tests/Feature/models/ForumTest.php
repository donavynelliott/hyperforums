<?php

namespace Tests\Feature;

use App\Announcement;
use App\Forum;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ForumTest extends TestCase
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
        $this->announcement = factory('App\Announcement')->create();

        $this->actingAs($user);
    }

    public function testForumCanAddThread()
    {
        $forum = $this->forum;
        $thread = [
            'forum_id' => $forum->id,
            'title' => 'New Thread',
            'body' => 'This is a new thread',
        ];

        $forum->addThread($thread);

        $this->assertDatabaseHas('threads', $thread);
    }

    public function testForumCanHaveThread()
    {
        $findThread = $this
            ->forum
            ->threads()
            ->find($this->thread->id);
        $this->assertTrue($findThread instanceof Thread);
    }

    public function testForumCanFindReplies()
    {
        $findReply = $this->forum
            ->replies()
            ->find($this->reply->id);
        $this->assertTrue($findReply instanceof Reply);
    }

    public function testForumCanFindAnnouncements()
    {
        $announcement = $this->forum
            ->announcements()
            ->find($this->announcement->id);
        $this->assertTrue($announcement instanceof Thread);
    }
}
