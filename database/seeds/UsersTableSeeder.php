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
            'name' => 'root',
            'role_id' => '1',
            'active' => true,
            'email' => 'wwe@php.loc',
            'password' => bcrypt('12345q'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'name' => 'moderator',
            'role_id' => '2',
            'active' => true,
            'email' => 'moderator@php.loc',
            'password' => bcrypt('12345q'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'role_id' => '3',
            'active' => true,
            'email' => 'user@php.loc',
            'password' => bcrypt('12345q'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'name' => 'test1',
            'role_id' => '2',
            'active' => true,
            'email' => 'test1@php.loc',
            'password' => bcrypt('12345q'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'name' => 'test2',
            'role_id' => '3',
            'active' => true,
            'email' => 'test2@php.loc',
            'password' => bcrypt('12345q'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

    }
}
