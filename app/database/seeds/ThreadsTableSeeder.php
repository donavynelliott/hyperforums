<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
        	'user_id' => 1,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
