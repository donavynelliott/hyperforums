<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    public function threads()
    {
        return $this->hasMany('App\Thread');
    }

    public function latestAnnouncement()
    {
        return $this->announcements()->orderBy('created_at', 'desc')->first();
    }

    public function announcements()
    {
        return $this->hasMany('App\Announcement');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    public function addThread(array $thread)
    {
        $thread['user_id'] = Auth::id();
        return $this->threads()->create($thread);

    }
}
