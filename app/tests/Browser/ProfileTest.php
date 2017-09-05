<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUserProfiles()
    {
        $user = factory('App\User')->create();
        $user_id = $user->id;

        $this->browse(function (Browser $browser) use ($user, $user_id) {
            $browser->loginAs($user)
                    ->visit("/profile/${user_id}")
                    ->assertSee($user->name);
        });
    }
}
