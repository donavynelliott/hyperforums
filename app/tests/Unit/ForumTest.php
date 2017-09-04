<?php

namespace Tests\Unit;

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
        $this->get('/forum')->assertViewIs('forum');
    }
    
}
