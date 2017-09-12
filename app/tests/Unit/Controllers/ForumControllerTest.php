<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForumControllerTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->forum = factory('App\Forum')->create();
	}

	public function testForumControllerIndex()
	{
        $response = $this->get('forum');

        $response->assertViewHas('forums')
                        ->assertViewIs('forum.index');
	}

	public function testForumControllerShow()
	{
		$forum = $this->forum;
		$response = $this->get('forum/' . $forum->id);

		$response->assertViewHas(['forum', 'threads'])
					->assertViewIs('forum.show');
	}
}
