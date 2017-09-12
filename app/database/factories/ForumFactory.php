<?php

use Faker\Generator as Faker;

$factory->define(App\Forum::class, function (Faker $faker) {
	return [
		'name' => $faker->company,
		'priority' => $faker->numberBetween(1, 20)
	];
});

$factory->define(App\Thread::class, function (Faker $faker) {

	return [
		'user_id' => function () {
		    	return factory('App\User')->create()->id;
		},
		'forum_id'	=> function() {
			return factory('App\Forum')->create()->id;
		},
		'title' => $faker->sentence,
		'body' => $faker->paragraph,
	];
});

$factory->define(App\Reply::class, function ($faker) {
	return [
		'thread_id' => function () {
			return factory('App\Thread')->create()->id;
		},
	    	'user_id' => function () {
	        		return factory('App\User')->create()->id;
	    	},
    		'body'  => $faker->paragraph
	];
});