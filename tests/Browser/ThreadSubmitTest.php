<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ThreadSubmitTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testThreadsCannotBeSubmittedWithMissingFields()
    {
        $user = factory('App\User')->create();
        $forum_id = factory('App\Forum')->create()->id;
        $this->browse(function (Browser $browser) use ($user, $forum_id) {
            $browser->loginAs($user)
                ->visit("/forum/${forum_id}/threads/create")
                ->type('title', 'missingFieldsTests')
                ->click('[type="submit"]')
                ->assertSeeIn('.alert-danger', 'The body field is required.')
                ->clear('title')
                ->type('body', 'missingFieldsTest')
                ->click('[type="submit"]')
                ->assertSeeIn('.alert-danger', 'The title field is required.');
        });
    }
}
