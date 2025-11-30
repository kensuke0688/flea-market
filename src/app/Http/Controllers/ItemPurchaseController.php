<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;


class ItemPurchaseController extends Controller
{
    public function show(Item $item)
    {
        return view('item_purchase', compact('item'));
    }

    public function store(PurchaseRequest $request, Item $item)
    {
        $validated = $request->validated();

        Order::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'shipping_address' => auth()->user()->address,
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('mypage')->with('success', '購入が完了しました！');
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        return view('address_edit', compact('item', 'user'));
    }

    // 配送先住所の更新処理
    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'post_number' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $user->update([
            'post_number' => $request->post_number,
            'address' => $request->address,
            'building_name' => $request->building_name,
        ]);

        return redirect()->route('purchase.show', $item_id)
            ->with('success', '配送先住所を更新しました。');
    }
}
