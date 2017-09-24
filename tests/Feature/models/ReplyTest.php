<?php

namespace Tests\Unit;

use App\Forum;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->reply = factory('App\Reply')->create();

        $this->actingAs($this->reply->user);
    }

    public function testReplyBelongsToForum()
    {
        $this->assertTrue($this->reply->forum instanceof Forum);
    }

    public function testReplyBelongsToThread()
    {
        $this->assertTrue($this->reply->thread instanceof Thread);
    }

    public function testReplyBelongsToUser()
    {
        $this->assertTrue($this->reply->user instanceof User);
    }
}
