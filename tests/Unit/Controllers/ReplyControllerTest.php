<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyController extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory('App\User')->create();
        $this->thread = factory('App\Thread')->create();
        $this->reply = factory('App\Reply')->create();
    }

    public function testReplyControllerStore()
    {
        $user = $this->user;
        $thread = $this->thread;
        $reply = array(
            'user_id' => $user->id,
            'thread_id' => $thread->id,
            'body' => 'testReplyControllerStore',
        );

        $response = $this->post('/forum/' . $thread->forum->id . '/threads/' . $thread->id . '/replies', $reply);

        $response->assertRedirect('/login');

        $response = $this->actingAs($user)
            ->post('/forum/' . $thread->forum->id . '/threads/' . $thread->id . '/replies', $reply);

        $response->assertStatus(302);
    }

    public function testReplyControllerEdit()
    {
        $reply = $this->reply;
        $author = $reply->user;

        $response = $this->get('/replies/' . $reply->id . '/edit');

        $response->assertRedirect('/login');

        $response = $this->actingAs($author)
            ->get('/replies/' . $reply->id . '/edit');

        $response->assertViewIs('forum.thread.reply.edit')
            ->assertViewHas('reply');
    }

    public function testReplyControllerUpdate()
    {
        $reply = $this->reply;
        $thread = $reply->thread;
        $forum_id = $thread->forum->id;
        $author = $reply->user;
        $randomUser = factory('App\User')->create();

        $replyUpdate = array(
            'body' => 'testThreadControllerUpdateTitle',
        );

        $response = $this->put('/replies/' . $reply->id, $replyUpdate);

        $response->assertStatus(302)
            ->assertRedirect('/login');

        $response = $this->actingAs($randomUser)
            ->put('/replies/' . $reply->id, $replyUpdate);

        $response->assertStatus(500);

        $response = $this->actingAs($author)
            ->put('/replies/' . $reply->id, $replyUpdate);

        $response->assertStatus(302)
            ->assertRedirect('/forum/' . $forum_id . '/threads/' . $thread->id);
    }
}
