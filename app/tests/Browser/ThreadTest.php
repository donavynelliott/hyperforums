<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUserCanSeeThreads()
    {
        $thread = factory('App\Thread')->create();

        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum')
                            ->assertSee($thread->title);
        });
    }

    public function testUserCanSeeSingleThread() 
    {
        $thread = factory('App\Thread')->create();

        $this->browse(function ($browser) use ($thread) {
            $browser->visit('/forum')
                            ->clickLink($thread->title)
                            ->assertSee($thread->body);
        });
    }

    public function testUserCanSeeThreadReplies()
    {
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);

        $this->browse(function ($browser) use ($thread, $reply) {
            $browser->visit('/forum')
                            ->clickLink($thread->title)
                            ->assertSee($reply->body);
                            
        });
    }
}
