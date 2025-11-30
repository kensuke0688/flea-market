<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Support\Facades\View;

class FavoriteTest extends TestCase
{
    use WithoutMiddleware; // 認証などミドルウェアを無効化（必要に応じて）

    public function testUserCanFavoriteItem()
    {
        $userId = 1;

        // モック化した商品データ
        $itemMock = (object)[
            'id' => 1,
            'item_name' => '商品A',
            'favorites_count' => 0,
            'isFavoritedBy' => fn($id) => false, // 最初は未いいね
        ];

        // ビューで $item にモックを渡す
        View::composer('item.show', function ($view) use ($itemMock) {
            $view->with('item', $itemMock);
        });

        // ログインユーザーを擬似的に作成
        $user = User::factory()->make(['id' => $userId]);
        $this->actingAs($user);

        // いいね POST リクエストを送信（ルートは your-route-name に置き換え）
        $response = $this->post(route('items.favorite', $itemMock->id));

        // ステータス確認
        $response->assertStatus(200);

        // JSON で返る場合、favorites_count が増加しているか確認
        $response->assertJson([
            'favorites_count' => 1,
            'favorited' => true,
        ]);
    }
}