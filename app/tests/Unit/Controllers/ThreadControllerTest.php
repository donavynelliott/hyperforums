<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadController extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
        $this->thread = factory('App\Thread')->create();
    }

    public function testThreadControllerCreate()
    {
        $forum_id = $this->thread->forum->id;

        $response = $this->get('/forum/' . $forum_id . '/threads/create');

        $response->assertRedirect('/login');

        $response = $this->actingAs($this->user)
            ->get('/forum/' . $forum_id . '/threads/create');

        $response->assertViewIs('forum.thread.create')
            ->assertViewHas('thread');
    }

    public function testThreadControllerEdit()
    {
        $thread = $this->thread;

        $response = $this->get('/threads/' . $thread->id . '/edit');

        $response->assertRedirect('/login');

        $response = $this->actingAs($this->user)
            ->get('/threads/' . $thread->id . '/edit');

        $response->assertViewIs('forum.thread.edit');
    }

    public function testThreadControllerStore()
    {
        $forum_id = $this->thread->forum->id;
        $user = $this->user;
        $thread = array(
            'title' => 'testThreadControllerStoreTitle',
            'body' => 'testThreadControllerStoreBody',
            'user_id' => $user->id,
        );

        $response = $this->post('/forum/' . $forum_id . '/threads/store', $thread);

        $response->assertStatus(302);

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

    public function testThreadControllerUpdate()
    {
        $thread = $this->thread;
        $forum_id = $thread->forum->id;
        $user = $thread->user;
        $threadUpdate = array(
            'id' => $thread->id,
            'title' => 'testThreadControllerUpdateTitle',
            'body' => 'testThreadControllerUpdateBody',
        );

        $response = $this->post('/threads/store', $threadUpdate);

        $response->assertStatus(500);

        $response = $this->actingAs($user)
            ->post('/threads/store', $threadUpdate);

        $response->assertStatus(302)
            ->assertRedirect('/forum/' . $forum_id . '/threads/' . $thread->id);
    }
}
