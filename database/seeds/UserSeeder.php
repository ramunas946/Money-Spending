<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('graphs')->insert([
            'user_id' => 1,
            'money' => 0,
        ]);
        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('graphs')->insert([
            'user_id' => 2,
            'money' => 0,
        ]);
    }
}
