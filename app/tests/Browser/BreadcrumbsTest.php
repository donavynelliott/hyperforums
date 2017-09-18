<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BreadcrumbsTest extends DuskTestCase
{
    use DatabaseMigrations;

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
        $this->browse(function (Browser $browser, Browser $authBrowser) use ($user) {
            $authBrowser->loginAs($user)
                ->visit('/home')
                ->assertSeeIn('.breadcrumb', 'Home');
        });

    }

    public function testForumBreadcrumbs()
    {
        $user = $this->user;
        $forum = $this->forum;
        $thread = $this->thread;
        $this->browse(function (Browser $browser, Browser $authBrowser) use ($user, $forum, $thread) {
            $browser->visit('/forum') // /forum
                ->assertSeeIn('.breadcrumb', 'Home')
                ->assertSeeIn('.breadcrumb', 'Forums')
                ->clickLink($forum->name) // /forum/{forum_id}
                ->assertSeeIn('.breadcrumb', 'Forums')
                ->assertSeeIn('.breadcrumb', $forum->name)
                ->clickLink($thread->title) // /forum/{forum_id}/threads/{thread_id}
                ->assertSeeIn('.breadcrumb', 'Home')
                ->assertSeeIn('.breadcrumb', 'Forums')
                ->assertSeeIn('.breadcrumb', $forum->name)
                ->assertSeeIn('.breadcrumb', $thread->title);

            $authBrowser->loginAs($user)
                ->visit('/forum/' . $forum->id . '/threads/create')
                ->assertPathBeginsWith('/forum')
                ->assertSeeIn('.breadcrumb', 'Home')
                ->assertSeeIn('.breadcrumb', 'Forums')
                ->assertSeeIn('.breadcrumb', $forum->name)
                ->assertSeeIn('.breadcrumb', 'Create Thread');

            $browser->visit('/password/reset')
                ->assertPathBeginsWith('/password')
                ->assertSeeIn('.breadcrumb', 'Home')
                ->assertSeeIn('.breadcrumb', 'Password Reset');

            $browser->visit('/register')
                ->assertSeeIn('.breadcrumb', 'Home')
                ->assertSeeIn('.breadcrumb', 'Register');

            $browser->visit('/login')
                ->assertSeeIn('.breadcrumb', 'Home')
                ->assertSeeIn('.breadcrumb', 'Login');

            $browser->visit('/profile/' . $user->id)
                ->assertSeeIn('.breadcrumb', 'Home')
                ->assertSeeIn('.breadcrumb', $user->name);
        });
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
