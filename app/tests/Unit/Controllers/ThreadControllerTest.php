<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadController extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
        $this->thread = factory('App\Thread')->create();
    }

    public function testThreadControllerIndex()
    {
        $response = $this->actingAs($this->user)
                                      ->get('forum');

        $response->assertViewHas('threads')
                        ->assertViewIs('forum.index');
    }

    public function testThreadControllerCreate()
    {
        $forum_id = $this->thread->forum->id;
        $response = $this->actingAs($this->user)
                                    ->get('/forum/' . $forum_id . '/threads/create');

        $response->assertViewIs('forum.thread.create');
    }

    public function testThreadControllerStore()
    {
        $forum_id = $this->thread->forum->id;
        $user = $this->user;
        $thread = array(
                            'title' => 'testThreadControllerStoreTitle',
                            'body' => 'testThreadControllerStoreBody',
                            'user_id' => $user->id
                        );
        $response = $this->actingAs($user)
                                    ->post('/forum/' . $forum_id . '/threads/store', $thread);

        $response->assertStatus(302);
    }

    public function testThreadControllerShow()
    {
        $thread = $this->thread;
        $forum_id = $thread->forum->id;
        $response = $this->get('/forum/' . $forum_id . '/threads/' . $thread->id);

        $response->assertViewIs('forum.thread.show')
                        ->assertViewHas('thread');
    }
}
