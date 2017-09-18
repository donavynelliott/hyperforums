<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfileTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory('App\User')->create();
    }

    public function testUserProfiles()
    {
        $user = $this->user;
        $user_id = $user->id;

        $this->browse(function (Browser $browser) use ($user, $user_id) {
            $browser->visit("/profile/${user_id}")
                ->assertSee($user->name);
        });
    }

    public function testUserCanViewProfile()
    {
        $user = $this->user;
        $user_id = $user->id;

        $this->browse(function (Browser $browser) use ($user, $user_id) {
            $browser->loginAs($user)
                ->visit("/profile")
                ->assertSee($user->name);
        });
    }
}
