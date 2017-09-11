<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ForumTest extends DuskTestCase
{
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
}
