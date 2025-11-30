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
        'name' => '山田 太郎',
        'email' => 'taro@example.com',
        'password' => Hash::make('password123'), 
        'post_number' => '100-0001',
        'address' => '東京都千代田区千代田1-1',
        'building_name' => '皇居タワー101',
        'profile_img' => 'default.jpg', 
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
