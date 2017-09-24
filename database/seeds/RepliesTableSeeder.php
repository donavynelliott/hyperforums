<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('replies')->insert([
            'forum_id' => 2,
            'thread_id' => 2,
            'user_id' => 1,
            'body' => 'Welcome to Hyper Forums Robert.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
