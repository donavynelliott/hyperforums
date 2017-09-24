<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'don',
            'email' => 'don@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'Robert',
            'email' => 'robert@gmail.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
