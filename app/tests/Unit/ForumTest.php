<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ForumTest extends TestCase
{
	use DatabaseMigrations;
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testForum()
    {
        $this->get('/forum')->assertStatus(200);
    }
    
}
