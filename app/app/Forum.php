<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
	public function threads()
	{
		return $this->hasMany('App\Thread');
	}

	public function replies()
	{
		return $this->hasMany('App\Reply');
	}

	public function addThread(array $thread)
	{
		$thread = $this->threads()->create($thread);
		return $thread;
	}
}
