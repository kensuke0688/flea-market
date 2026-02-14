<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    [
        'id' => 1,
        'name' => 'ユーザーA',
        'email' => 'usera@test.com',
        'password' => Hash::make('password'), 
        'post_number' => '100-0001',
        'address' => '東京都千代田区千代田1-1',
        'profile_img' => 'default.jpg', 
        'created_at' => now(),
        'updated_at' => now(),
    ],

    [
        'id' => 2,
        'name' => 'ユーザーB',
        'email' => 'userb@test.com',
        'password' => Hash::make('password'),
        'post_number' => '100-0002',
        'address' => '東京都練馬区下石神井1-1',
        'profile_img' => 'default.jpg',
        'created_at' => now(),
        'updated_at' => now(),
    ],

    [
        'id' => 3,
        'name' => 'ユーザーC',
        'email' => 'userc@test.com',
        'password' => Hash::make('password'),
        'post_number' => '100-0003',
        'address' => '東京都練馬区下石神井1-2',
        'profile_img' => 'default.jpg',
        'created_at' => now(),
        'updated_at' => now(),
    ],

]);
    }
}
