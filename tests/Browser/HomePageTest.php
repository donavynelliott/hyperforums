<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testAnnouncementBoxShowsLatestAnnouncement()
    {
        $newAnnouncement = factory('App\Announcement')->create();
        $this->browse(function ($browser) {
            $browser->visit(new HomePage($browser))
                ->waitFor('@AnnouncementBox')
                ->assertSeeIn('@AnnouncementBox', $newAnnouncement->title);
        });
    }

    public function testRecentPostsContainerHasRecentThreads()
    {
        $threads = factory('App\Thread', 3)->create();
        $threeNewThreadTitles = $threads->pluck('title');
        $this->browse(function ($browser) use ($threeNewThreadTitles) {
            $browser->visit(new HomePage($browser))
                ->waitFor('@RecentThreads')
                ->assertSeeIn('@RecentThreads', $threeNewThreadTitles[0])
                ->assertSeeIn('@RecentThreads', $threeNewThreadTitles[1])
                ->assertSeeIn('@RecentThreads', $threeNewThreadTitles[2]);
        });
    }
}
