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

        $this->reply = factory('App\Reply')->create();
        $this->thread = $this->reply->thread;
        $this->user = $this->reply->user;
    }

    public function testUserCanSeeThreadReplies()
    {
        $reply = $this->reply;

        $this->browse(function ($browser) use ($reply) {
            $browser->visit('/forum/' . $reply->forum->id)
                ->clickLink($reply->thread->title) //click on link
                ->assertSee($reply->thread->title)
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

    public function testAuthUsersSeeErrorsForMissingFieldsWhenSubmittingNewReply()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->loginAs($thread->user)
                ->visit('/forum/' . $thread->forum->id . '/threads/' . $thread->id)
                ->click('[type="submit"]')
                ->assertSeeIn('.alert-danger', 'The body field is required.');
        });
    }

    public function testAuthenticatedUsersCanSubmitReplyToThread()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->loginAs($thread->user)
                ->visit('/forum/' . $thread->forum->id . '/threads/' . $thread->id)
                ->type('body', 'This is a reply')
                ->click('[type="submit"]')
                ->assertSee('This is a reply')
                ->assertSee($thread->user->name);
        });
    }

    public function testOnlyReplyAuthorCanSeeEditButton()
    {
        $reply = $this->reply;

        $this->browse(function ($browser) use ($reply) {
            $author = $reply->user;
            $thread = $reply->thread;
            $url = '/forum/' . $thread->forum->id . '/threads/' . $thread->id;
            $editButton = '[name="reply_' . $reply->id . '_edit"]';
            $randomUser = factory('App\User')->create();

            $browser->logout()
                ->visit($url)
                ->assertMissing($editButton)

                ->loginAs($randomUser)
                ->visit($url)
                ->assertMissing($editButton)

                ->loginAs($author)
                ->visit($url)
                ->assertSeeIn($editButton, 'Edit Reply');
        });
    }

    public function testReplyAuthorSeeErrorsForMissingFieldsWhenEditingReply()
    {
        $reply = $this->reply;

        $this->browse(function ($browser) use ($reply) {
            $browser->loginAs($reply->user)
                ->visit('/replies/' . $reply->id . '/edit')
                ->clear('body')
                ->click('[type="submit"]')
                ->assertSeeIn('.alert-danger', 'The body field is required.');
        });
    }

    public function testReplyAuthorCanEditReply()
    {
        $reply = $this->reply;

        $this->browse(function ($browser) use ($reply) {
            $thread = $reply->thread;
            $author = $reply->user;

            $browser->visit('/forum/' . $thread->forum->id . '/threads/' . $thread->id)
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

        $this->browse(function ($browser) use ($reply) {
            $randomUser = factory('App\User')->create();

            $browser->loginAs($randomUser)
                ->visit('/replies/' . $reply->id . '/edit')
                ->assertSee('You must be the author of this reply to edit.');
        });
    }
}
