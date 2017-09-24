<?php

namespace Tests\Feature;

use App\Forum;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->announcement = factory('App\Announcement')->create();
        $this->forum = $this->announcement->forum;
    }

    public function testAnnouncementIsInstanceOfThread()
    {
        $this->assertTrue($this->announcement instanceof Thread);
    }
}
