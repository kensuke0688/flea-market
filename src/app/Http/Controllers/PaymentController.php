<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Item;
use App\Models\Order;

class PaymentController extends Controller
{
    public function checkout(PurchaseRequest $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $item = Item::find($request->item_id);

        if (!$item) {
            return back()->withErrors(['item' => '商品が存在しません。']);
        }

        $paymentMethod = $request->payment_method ;

        $session = Session::create([
            'payment_method_types' => [$paymentMethod],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->item_name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
            'metadata' => [
                'user_id' => auth()->id(),
                'item_id' => $item->id,
                'shipping_address' => $request->address ?? auth()->user()->address,
                'payment_method' => $paymentMethod,
            ],
        ]);

        Order::create([
            'user_id' => $session->metadata->user_id,
            'item_id' => $session->metadata->item_id,
            'shipping_address' => $session->metadata->shipping_address,
            'payment_method' => $session->metadata->payment_method,
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        return view('payment.success');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
}
