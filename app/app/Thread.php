<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	protected $fillable = [
		'title',
		'body',
		'user_id',
		'forum_id'
	];

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
