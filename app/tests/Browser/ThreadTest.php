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
                            ->clickLink($thread->title)
                            ->assertSee($thread->body);
        });
    }

    public function testUserCanSeeThreadReplies()
    {
        $thread = $this->thread;
        $reply = $this->reply;

        $this->browse(function ($browser) use ($thread, $reply) {
            $browser->visit('/forum')
                            ->clickLink($thread->title)
                            ->assertSee($reply->body);
                            
        });
    }
}
