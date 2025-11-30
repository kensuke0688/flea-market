<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    /** @test */
    public function item()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Item::insert([
            [
                'item_name' => '商品A',
                'description' => '商品Aの説明',
                'price' => 1000,
                'item_img' => 'sampleA.jpg',
                'condition' => '新品',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => '商品B',
                'description' => '商品Bの説明',
                'price' => 2000,
                'item_img' => 'sampleB.jpg',
                'condition' => '中古',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->actingAs($user); 

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertSee('商品B');
    }

    public function testItemPurchased()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'item_name'   => '商品A',
            'description' => '商品Aの説明',
            'price'       => 1000,
            'item_img'    => 'sampleA.jpg',
            'condition'   => '新品',
            'user_id'     => $user->id,
        ]);

        $item->orders()->create([
            'user_id'         => $user->id,
            'shipping_address' => '東京都千代田区1-1-1',
            'payment_method'  => 'credit_card',        
            'total_price'     => $item->price,          
        ]);

        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    
}
