<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
}
