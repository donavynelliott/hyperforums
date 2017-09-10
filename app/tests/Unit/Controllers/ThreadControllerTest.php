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
        $response = $this->actingAs($this->user)
                                    ->get('threads/create');

        $response->assertViewIs('forum.create');
    }

    public function testThreadControllerStore()
    {
        $user = $this->user;
        $thread = array(
                            'title' => 'testThreadControllerStoreTitle',
                            'body' => 'testThreadControllerStoreBody',
                            'user_id' => $user->id
                        );
        $response = $this->actingAs($user)
                                    ->post('threads', $thread);
        $response->assertStatus(302);
    }

    public function testThreadControllerShow()
    {
        $thread = $this->thread;
        $response = $this->get('forum/' . $thread->id);

        $response->assertViewIs('forum.show')
                        ->assertViewHas('thread');
    }
}
