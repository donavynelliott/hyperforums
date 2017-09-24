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
        $threadCount = $forum->threads->count();

        $this->browse(function ($browser) use ($forum, $threadCount) {
            $browser->visit('/forum')
                ->assertSeeIn('[name="forum_' . $forum->id . '_thread_count"]', $threadCount);
        });
    }

    public function testThreadReplyCountIsVisible()
    {
        $forum = $this->forum;
        $replyCount = $forum->replies->count();

        $this->browse(function ($browser) use ($forum, $replyCount) {
            $browser->visit('/forum')
                ->assertSeeIn('[name="forum_' . $forum->id . '_reply_count"]', $replyCount);
        });
    }

    public function testForumsAreSortedHighestPriorityFirst()
    {
        $forum = factory('App\Forum')->create(['priority' => 1001]);
        $lastForum = factory('App\Forum')->create(['priority' => -1]);
        $otherForums = factory('App\Forum', 3)->create();

        $this->browse(function ($browser) use ($forum, $lastForum) {
            $browser->visit('/forum')
                ->assertSeeIn('#forums > tbody > tr:nth-child(1) > td:nth-child(1) > a', $forum->name)
                ->assertSeeIn('#forums > tbody > tr:last-child > td:nth-child(1) > a', $lastForum->name);
        });
    }
}
