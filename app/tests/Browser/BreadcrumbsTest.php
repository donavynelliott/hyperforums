<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BreadcrumbsTest extends DuskTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->reply = factory('App\Reply')->create();
        $this->thread = $this->reply->thread;
        $this->forum = $this->thread->forum;
        $this->user = factory('App\User')->create();
    }

    public function testHomeBreadcrumbs()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->assertSeeIn('.breadcrumb', 'Home');
        });

    }

    public function testForumBreadcrumbs()
    {
        $user = $this->user;
        $forum = $this->forum;
        $thread = $this->thread;
        $this->browse(function (Browser $browser) use ($user, $forum, $thread) {
            $browser->visit('/forum') // /forum
                    ->assertSeeIn('.breadcrumb', 'Forums')
                    ->clickLink($forum->name) // /forum/{forum_id}
                    ->assertSeeIn('.breadcrumb', 'Forums')
                    ->assertSeeIn('.breadcrumb', $forum->name)
                    ->clickLink($thread->title)// /forum/{forum_id}/threads/{thread_id}
                    ->assertSeeIn('.breadcrumb', 'Forums')
                    ->assertSeeIn('.breadcrumb', $forum->name)
                    ->assertSeeIn('.breadcrumb', $thread->title);

            $browser->visit('/forum/' . $forum->id . '/threads/create')
                    ->assertSeeIn('.breadcrumb', 'Forums')
                    ->assertSeeIn('.breadcrumb', $forum->name)
                    ->assertSeeIn('.breadcrumb', 'Create Thread');

        });
    }
}
