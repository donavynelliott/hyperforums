<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Forum $forum, Thread $thread)
    {
        $request->validate([
            'body' => 'bail|required|min:5|max:2000',
        ]);
        $thread->addReply(array(
            'body' => $request->input('body'),
            'user_id' => $request->user()->id,
            'forum_id' => $thread->forum->id,
        ));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        return view('forum.thread.reply.edit', compact('reply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        if ($request->user()->id != $reply->user->id) {
            abort(500);
        }

        $request->validate([
            'body' => 'bail|required|min:5|max:2000',
        ]);

        $reply->body = $request->input('body');
        $reply->save();
        $thread = $reply->thread;
        $forum = $thread->forum;

        return redirect()->route('threads.show', compact('forum', 'thread'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        //
    }
}
