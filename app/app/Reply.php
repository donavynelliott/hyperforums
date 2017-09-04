<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function thread()
    {
    	return $this->hasOne('App\Thread');
    }

    public function user()
    {
    	return $this->hasOne('App\User');
    }
}
