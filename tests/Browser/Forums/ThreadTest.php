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
                ->assertSee($thread->user->name);
        });
    }

    public function testAuthUsersSeeErrorsForMissingFieldsWhenSubmittingNewThread()
    {
        $user = $this->user;
        $forum_id = $this->thread->forum->id;

        $this->browse(function ($browser) use ($user, $forum_id) {
            $browser->loginAs($user)
                ->visit('/forum/' . $forum_id . '/threads/create')
                ->click('[type="submit"]')
                ->assertPathBeginsWith('/forum/')
                ->assertSeeIn('.alert-danger', 'The title field is required.')
                ->assertSeeIn('.alert-danger', 'The body field is required.');
        });
    }

    public function testAuthUsersCanSubmitNewThread()
    {
        $user = $this->user;
        $forum_id = $this->thread->forum->id;

        $this->browse(function ($browser) use ($user, $forum_id) {
            $browser->loginAs($user)
                ->visit('/forum/' . $forum_id . '/threads/create')
                ->type('title', 'This is a title')
                ->type('body', 'This is a body')
                ->click('[type="submit"]')
                ->assertPathBeginsWith('/forum/')
                ->assertSee('This is a title')
                ->assertSee('This is a body')
                ->assertSeeIn('.alert-success', 'Your thread has been posted');
        });
    }

    public function testOnlyThreadAuthorCanSeeEditAndDeleteButton()
    {
        $thread = $this->thread;
        $author = $thread->user;
        $forum_id = $thread->forum->id;
        $randomUser = factory('App\User')->create();

        $this->browse(function ($browser) use ($thread, $author, $forum_id, $randomUser) {
            $browser->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->assertMissing('[name="thread_' . $thread->id . '_edit"]')
                ->assertMissing('[name="thread_' . $thread->id . '_delete"]')
                ->loginAs($randomUser)
                ->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->assertMissing('[name="thread_' . $thread->id . '_edit"]')
                ->assertMissing('[name="thread_' . $thread->id . '_delete"]')
                ->loginAs($author)
                ->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->assertSeeIn('[name="thread_' . $thread->id . '_edit"]', 'Edit Thread')
                ->assertSeeIn('[name="thread_' . $thread->id . '_delete"]', 'Delete Thread');
        });
    }

    public function testAuthUserSeeAuthorWarningWhenAttemptingToEditOthersThread()
    {
        $thread = $this->thread;
        $randomUser = factory('App\User')->create();

        $this->browse(function ($browser) use ($thread, $randomUser) {
            $browser->loginAs($randomUser)
                ->visit('/threads/' . $thread->id . '/edit')
                ->assertSee('You must be the author of this thread to edit.');
        });
    }

    public function testThreadAuthorSeeErrorsForMissingFieldsWhenEditingThread()
    {
        $thread = $this->thread;
        $user = $thread->user;

        $this->browse(function ($browser) use ($thread, $user) {
            $browser->loginAs($user)
                ->visit('/threads/' . $thread->id . '/edit')
                ->clear('title')
                ->clear('body')
                ->click('[type="submit"]')
                ->assertSeeIn('.alert-danger', 'The title field is required.')
                ->assertSeeIn('.alert-danger', 'The body field is required.');
        });
    }

    public function testThreadAuthorCanDeleteThread()
    {
        $thread = $this->thread;
        $user = $thread->user;
        $forum_id = $thread->forum->id;

        $this->browse(function ($browser) use ($thread, $user, $forum_id) {
            $browser->loginAs($user)
                ->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->click('[name="thread_1_delete"]')
                ->click('.swal-button--confirm')
                ->assertPathIs('/forum/' . $forum_id)
                ->assertDontSee($thread->title)
                ->assertDontSee($thread->body)
                ->assertSeeIn('.alert-info', 'The thread has been deleted.');
        });
    }

    public function testThreadAuthorCanEditThread()
    {
        $thread = $this->thread;
        $user = $thread->user;
        $forum_id = $thread->forum->id;

        $this->browse(function ($browser) use ($thread, $user, $forum_id) {
            $browser->loginAs($user)
                ->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->clickLink('Edit Thread')
                ->assertPathBeginsWith('/threads/')
                ->assertSee($thread->title)
                ->assertSee($thread->body)
                ->type('title', 'testThreadAuthorCanEditThreadtitle')
                ->type('body', 'testThreadAuthorCanEditThreadbody')
                ->click('[type="submit"]')
                ->assertSee('testThreadAuthorCanEditThreadtitle')
                ->assertSee('testThreadAuthorCanEditThreadbody')
                ->assertPathBeginsWith('/forum/');
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
