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
        $this->newAnnouncement = factory('App\Announcement')->create();
    }

    public function testAnnouncementBoxShowsLatestAnnouncement()
    {
        $this->browse(function ($browser) {
            $browser->visit(new HomePage($browser))
                ->waitFor('@AnnouncementBox')
                ->assertSeeIn('@AnnouncementBox', $this->newAnnouncement->title);
        });
    }
}
