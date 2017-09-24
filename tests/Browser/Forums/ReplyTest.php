<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReplyTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
        $this->reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
        $this->user = factory('App\User')->create();
    }

    public function testUserCanSeeThreadReplies()
    {
        $thread = $this->thread;
        $reply = $this->reply;

        $this->browse(function ($browser) use ($thread, $reply) {
            $browser->visit('/forum/' . $thread->forum->id)
                ->clickLink($thread->title) //click on link
                ->assertSee($thread->title)
                ->assertSee($reply->body) //body is visible
                ->assertSee($reply->user->name);

        });
    }
    public function testAnonUsersCantReplyToThreads()
    {
        $thread = $this->thread;
        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum/' . $thread->forum->id . '/threads/' . $thread->id)
                ->assertSee('Login to reply to threads.')
                ->click('#login-to-reply')
                ->assertPathIs('/login');
        });
    }

    public function testAuthenticatedUsersCanSubmitReplyToThread()
    {
        $user = $this->user;
        $thread = $this->thread;
        $this->browse(function ($browser) use ($user, $thread) {
            $browser->loginAs($user)
                ->visit('/forum/' . $thread->forum->id . '/threads/' . $thread->id)
                ->type('body', 'This is a reply')
                ->click('[type="submit"]')
                ->assertSee('This is a reply')
                ->assertSee($user->name);
        });
    }

    public function testOnlyReplyAuthorCanSeeEditButton()
    {
        $reply = $this->reply;
        $author = $reply->user;
        $thread = $reply->thread;
        $forum_id = $thread->forum->id;
        $randomUser = factory('App\User')->create();

        $this->browse(function ($browser) use ($reply, $author, $thread, $forum_id, $randomUser) {
            $browser->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->assertMissing('[name="reply_' . $reply->id . '_edit"]')
                ->loginAs($randomUser)
                ->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->assertMissing('[name="reply_' . $reply->id . '_edit"]')
                ->loginAs($author)
                ->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->assertSeeIn('[name="reply_' . $reply->id . '_edit"]', 'Edit Reply');
        });
    }

    public function testReplyAuthorCanEditReply()
    {
        $reply = $this->reply;
        $thread = $reply->thread;
        $forum_id = $thread->forum->id;
        $author = $reply->user;

        $this->browse(function ($browser) use ($reply, $thread, $forum_id, $author) {
            $browser->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->click('[name="reply_' . $reply->id . '_edit"]')
                ->assertPathBeginsWith('/replies')
                ->type('body', 'testReplyAuthorCanEditReplybody')
                ->click('[type="submit"]')
                ->assertSee('testReplyAuthorCanEditReplybody')
                ->assertPathBeginsWith('/forum');
        });
    }

    public function testAuthUserSeeAuthorWarningWhenAttemptingToEditOthersReply()
    {
        $reply = $this->reply;
        $randomUser = factory('App\User')->create();

        $this->browse(function ($browser) use ($reply, $randomUser) {
            $browser->loginAs($randomUser)
                ->visit('/replies/' . $reply->id . '/edit')
                ->assertSee('You must be the author of this reply to edit.');
        });
    }
}
