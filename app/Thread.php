<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'forum_id',
    ];

    // protected $dateFormat = 'Y-m-d H:i:s';
    protected $dateTimeFormat = "M";

    public function forum()
    {
        return $this->belongsTo('App\Forum');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function addReply(array $reply)
    {
        $this->replies()->create($reply);
    }
}
