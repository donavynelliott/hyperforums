<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
            $browser->visit('/forum/' . $thread->forum->id )
                            ->clickLink($thread->title) //click on link
                            ->assertSee($thread->title)
                            ->assertSee($reply->body) //body is visible
                            ->assertSee($reply->user->name);
                            
        });
    }
    public function testAnonUsersCantReplyToThreads()
    {
        $thread = $this->thread;
        $this->browse(function($browser) use($thread) {
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
}
