<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { //ForumController@show
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Forum $forum, Thread $thread)
    {
        return view('forum.thread.create', compact('forum', 'thread'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Forum $forum)
    {
        $request->validate([
            'title' => 'bail|required|max:255',
            'body' => 'required|min:1',
        ]);

        $thread = [
            'title' => $request->input('title'),
            'forum' => $forum,
            'body' => $request->input('body'),
            'user_id' => $request->user()->id,
        ];

        $thread = $forum->addThread($thread);

        flash('Your thread has been posted')->success();

        return redirect()
            ->route('threads.show', compact('forum', 'thread'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum, Thread $thread)
    {
        $replies = $thread->replies()->orderBy('created_at', 'asc')->get();
        return view('forum.thread.show', compact('thread', 'replies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        return view('forum.thread.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        if ($request->user()->id != $thread->user->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'bail|required|max:255',
            'body' => 'required|min:1',
        ]);

        $thread->title = $request->input('title');
        $thread->body = $request->input('body');
        $thread->save();
        $forum = $thread->forum;

        return redirect()->route('threads.show', compact('forum', 'thread'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
