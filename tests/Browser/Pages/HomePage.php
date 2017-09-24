<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class HomePage extends Page
{
    public function __construct(Browser $browser = null)
    {
        if ($browser != null) {
            $user = factory('App\User')->create();
            $browser->loginAs($user);
            return $this;
        }
        return $this;
    }
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/home';
    }

    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }
    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@AnnouncementBox' => '#latest-announcement',
        ];
    }
}
