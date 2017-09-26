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
    }

    public function testUserCanSeeAllThreads()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum/' . $thread->forum->id)
                ->assertSee($thread->title);
        });
    }

    public function testUserCanGoToThreadsPage()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum/' . $thread->forum->id)
                ->clickLink($thread->title)
                ->assertSee($thread->title)
                ->assertSee($thread->body)
                ->assertSee($thread->user->name);
        });
    }

    public function testAuthUsersSeeErrorsForMissingFieldsWhenSubmittingNewThread()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->loginAs($thread->user)
                ->visit('/forum/' . $thread->forum->id . '/threads/create')
                ->click('[type="submit"]')
                ->assertPathBeginsWith('/forum/')
                ->assertSeeIn('.alert-danger', 'The title field is required.')
                ->assertSeeIn('.alert-danger', 'The body field is required.');
        });
    }

    public function testAuthUsersCanSubmitNewThread()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->loginAs($thread->user)
                ->visit('/forum/' . $thread->forum->id . '/threads/create')
                ->type('title', 'This is a title')
                ->type('body', 'This is a body')
                ->click('[type="submit"]')
                ->assertPathBeginsWith('/forum/')
                ->assertSee('This is a title')
                ->assertSee('This is a body')
                ->assertSeeIn('.alert-success', 'Your thread has been posted.');
        });
    }

    public function testOnlyThreadAuthorCanSeeEditAndDeleteButton()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $author = $thread->user;
            $forum_id = $thread->forum->id;
            $randomUser = factory('App\User')->create();
            $editButton = '[name="thread_' . $thread->id . '_edit"]';
            $deleteButton = '[name="thread_' . $thread->id . '_delete"]';

            $browser->logout()
                ->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->assertMissing($editButton)
                ->assertMissing($deleteButton)

                ->loginAs($randomUser)
                ->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->assertMissing($editButton)
                ->assertMissing($deleteButton)

                ->loginAs($author)
                ->visit('/forum/' . $forum_id . '/threads/' . $thread->id)
                ->assertSeeIn($editButton, 'Edit Thread')
                ->assertSeeIn($deleteButton, 'Delete Thread');
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

    public function testThreadAuthorSeesErrorsForMissingFieldsWhenEditingThread()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->loginAs($thread->user)
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

        $this->browse(function ($browser) use ($thread) {
            $browser->loginAs($thread->user)
                ->visit('/forum/' . $thread->forum->id . '/threads/' . $thread->id)
                ->click('[name="thread_1_delete"]')
                ->click('.swal-button--confirm')
                ->assertPathIs('/forum/' . $thread->forum->id)
                ->assertDontSee($thread->title)
                ->assertDontSee($thread->body)
                ->assertSeeIn('.alert-success', 'The thread has been deleted.');
        });
    }

    public function testThreadAuthorCanEditThread()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->loginAs($thread->user)
                ->visit('/forum/' . $thread->forum->id . '/threads/' . $thread->id)
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
        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum/' . $thread->forum->id)
                ->assertSeeIn('[name="thread_' . $thread->id . '_reply_count"]', $thread->replies->count());
        });
    }

    public function testThreadCreatedTimeIsVisible()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum/' . $thread->forum->id)
                ->assertSeeIn('[name="thread_' . $thread->id . '_created_at"]', $thread->created_at->format('M j\\, Y g:ia'));
        });
    }
}
