<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('threads')->insert([
            'title' => 'Welcome to Hyperforums',
            'body' => 'This is an example post. Edit or delete me to get started.',
            'forum_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('threads')->insert([
            'title' => 'Hello I\'m rob',
            'body' => 'I like cars and posting to forums. Nice to meet you all.',
            'forum_id' => 2,
            'user_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
