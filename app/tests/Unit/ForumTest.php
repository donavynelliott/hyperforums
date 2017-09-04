<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForumTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testForum()
    {
        $thread = factory('App\Thread')->create();

        $this->get('/forum')->assertStatus(200);

        $this->assertSee($thread->title);
    }

    public function testAUserCanBrowseThreads()
    {

    }

    public function testForumFactories() {

    }
    
}
