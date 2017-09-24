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

        $response->assertViewIs('forum.thread.create');
    }

    public function testThreadControllerEdit()
    {
        $thread = $this->thread;
        $author = $thread->user;

        $response = $this->get('/threads/' . $thread->id . '/edit');

        $response->assertRedirect('/login');

        $response = $this->actingAs($author)
            ->get('/threads/' . $thread->id . '/edit');

        $response->assertViewIs('forum.thread.edit')
            ->assertViewHas('thread');
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
        $author = $thread->user;
        $randomUser = factory('App\User')->create();

        $threadUpdate = array(
            'id' => $thread->id,
            'title' => 'testThreadControllerUpdateTitle',
            'body' => 'testThreadControllerUpdateBody',
        );

        $response = $this->put('/threads/' . $thread->id, $threadUpdate);

        $response->assertStatus(302)
            ->assertRedirect('/login');

        $response = $this->actingAs($randomUser)
            ->put('/threads/' . $thread->id, $threadUpdate);

        $response->assertStatus(500);

        $response = $this->actingAs($author)
            ->put('/threads/' . $thread->id, $threadUpdate);

        $response->assertStatus(302)
            ->assertRedirect('/forum/' . $forum_id . '/threads/' . $thread->id);
    }
}
