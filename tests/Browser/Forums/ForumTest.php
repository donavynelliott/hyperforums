<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->forum = factory('App\Forum')->create();
    }

    public function testAllUsersCanSeeForums()
    {
        $forum = $this->forum;

        $this->browse(function ($browser) use ($forum) {
            $browser->visit('/forum')
                ->assertSee($forum->name);
        });
    }

    public function testAllUsersCanSeeForumThreadCount()
    {
        $forum = $this->forum;

        $this->browse(function ($browser) use ($forum) {
            $browser->visit('/forum')
                ->assertSeeIn('[name="forum_' . $forum->id . '_thread_count"]', $forum->threads->count());
        });
    }

    public function testThreadReplyCountIsVisible()
    {
        $forum = $this->forum;

        $this->browse(function ($browser) use ($forum) {
            $browser->visit('/forum')
                ->assertSeeIn('[name="forum_' . $forum->id . '_reply_count"]', $forum->replies->count());
        });
    }

    public function testForumsAreSortedHighestPriorityFirst()
    {
        $otherForums = factory('App\Forum', 3)->create();

        $this->browse(function ($browser) {
            $forum = factory('App\Forum')->create(['priority' => 1001]);
            $lastForum = factory('App\Forum')->create(['priority' => -1]);

            $browser->visit('/forum')
                ->assertSeeIn('#forums > tbody > tr:nth-child(1) > td:nth-child(1) > a', $forum->name)
                ->assertSeeIn('#forums > tbody > tr:last-child > td:nth-child(1) > a', $lastForum->name);
        });
    }
}
