<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	protected $fillable = [
		'title',
		'body',
		'user_id'
	];

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
