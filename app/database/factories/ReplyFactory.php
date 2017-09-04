<?php

use Faker\Generator as Faker;

$factory->define(App\Reply::class, function (Faker $faker) {
	return [
		'thread_id' => function () {
			return factory('App\Thread')->make()->id;
		},
		'user_id' => function () {
			return factory('App\User')->make()->id;
		},
		'body' => $faker->paragraph,
	];
});