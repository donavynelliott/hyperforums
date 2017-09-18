<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ThreadTest extends DuskTestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
        $this->reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
        $this->user = factory('App\User')->create();
    }

    public function testUserCanSeeThreads()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum/' . $thread->forum->id)
                ->assertSee($thread->title);
        });
    }

    public function testUserCanSeeSingleThread()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum/' . $thread->forum->id)
                ->clickLink($thread->title) //click on link
                ->assertSee($thread->title) //title is visible
                ->assertSee($thread->body) //body is visible
                ->assertSee($thread->user->name) //author is visible
                ->clickLink($thread->user->name) //click on author profile
                ->assertSee($thread->user->name); //profile is authors
        });
    }

    public function testAuthenticatedUsersCanSubmitNewThread()
    {
        $user = $this->user;
        $thread = $this->thread;
        $this->browse(function ($browser) use ($user, $thread) {
            $browser->loginAs($user)
                ->visit('/forum/' . $thread->forum->id . '/threads/create')
                ->type('title', 'This is a title')
                ->type('body', 'This is a body')
                ->click('[type="submit"')
                ->assertPathBeginsWith('/forum/')
                ->assertSee('This is a title')
                ->assertSee('This is a body');
        });
    }

    public function testThreadReplyCountIsVisible()
    {
        $thread = $this->thread;
        $replyCount = $thread->replies->count();
        $forum_id = $thread->forum->id;

        $this->browse(function ($browser) use ($thread, $replyCount, $forum_id) {
            $browser->visit('/forum/' . $forum_id)
                ->assertSeeIn('[name="thread_' . $thread->id . '_reply_count"]', $replyCount);
        });
    }

    public function testThreadCreatedTimeIsVisible()
    {
        $thread = $this->thread;
        $createdAt = $thread->created_at->format('M j\\, Y g:ia');
        $forum_id = $thread->forum->id;

        $this->browse(function ($browser) use ($thread, $createdAt, $forum_id) {
            $browser->visit('/forum/' . $forum_id)
                ->assertSeeIn('[name="thread_' . $thread->id . '_created_at"]', $createdAt);
        });
    }
}
