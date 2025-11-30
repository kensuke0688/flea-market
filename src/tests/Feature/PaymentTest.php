<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function testPaymentMethodSelectionIsReflectedWithoutFactory()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // パスワード必須
        ]);

        $item = Item::create([
            'item_name' => 'テスト商品',
            'description' => 'テスト商品説明',
            'price' => 1000,
            'item_img' => 'sample.jpg',
            'user_id' => $user->id,
            'condition' => 'new', // 必須
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'cash', // 必須
            'shipping_address' => '東京都テスト区1-1-1', // 必須
        ]);

        // 4. ログイン
        $this->actingAs($user);

        // 5. 支払い方法変更リクエスト
        $url = route('purchase.show', $item->id);

        // 例: GETリクエストで確認
        $response = $this->get($url);
        $response->assertStatus(200);

        // 6. 更新後リダイレクト確認
        $response->assertStatus(302);

        // 7. DB が更新されていることを確認
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'payment_method' => 'credit_card',
        ]);
    }
}