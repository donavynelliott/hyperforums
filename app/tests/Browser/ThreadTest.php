<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends DuskTestCase
{
    public function setUp()
    {
        parent::setUp();
        
        $this->thread = factory('App\Thread')->create();
        $this->reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
    }

    public function testUserCanSeeThreads()
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum')
                            ->assertSee($thread->title);
        });
    }

    public function testUserCanSeeSingleThread() 
    {
        $thread = $this->thread;

        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum')
                            ->clickLink($thread->title) //click on link
                            ->assertSee($thread->title) //title is visible
                            ->assertSee($thread->body) //body is visible
                            ->assertSee($thread->user->name) //author is visible
                            ->clickLink($thread->user->name) //click on author profile
                            ->assertSee($thread->user->name); //profile is authors 
        });
    }

    public function testUserCanSeeThreadReplies()
    {
        $thread = $this->thread;
        $reply = $this->reply;

        $this->browse(function ($browser) use ($thread, $reply) {
            $browser->visit('/forum')
                            ->clickLink($thread->title) //click on link
                            ->assertSee($thread->title)
                            ->assertSee($reply->body) //body is visible
                            ->assertSee($reply->user->name) //author is visible
                            ->clickLink($reply->user->name) //click on author profile
                            ->assertSee($reply->user->name); //is authors profile
                            
        });
    }

    public function testUserCanSubmitNewThread()
    {
        $user = factory('App\User')->create();
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/threads/create')
                            ->type('title', 'This is a title')
                            ->type('body', 'This is a body')
                            ->click('#submit')
                            ->assertSee('Thread Submitted!');
        }) ;  
    }
}
