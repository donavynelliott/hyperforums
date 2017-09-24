<?php

use App\Forum;
use Faker\Generator as Faker;

$factory->define(App\Announcement::class, function (Faker $faker) {
    if (Forum::find(1) == null) {
        factory('App\Forum')->create();
    }

    return [
        'forum_id' => '1',
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});
