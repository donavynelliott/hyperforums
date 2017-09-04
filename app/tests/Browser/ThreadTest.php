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
}
