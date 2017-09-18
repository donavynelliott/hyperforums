<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'user_id',
        'thread_id',
        'forum_id',
        'body',
    ];
    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function forum()
    {
        return $this->belongsTo('App\Forum');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
