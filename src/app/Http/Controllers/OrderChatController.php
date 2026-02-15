<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\Review;
use App\Models\User;
use App\Mail\TradeCompletedMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ChatMessageRequest;

class OrderChatController extends Controller
{
    public function show(Order $order)
    {
        $user = auth()->user();
        $chatRoom = ChatRoom::where('order_id', $order->id)->first();
        if (!$chatRoom) {
            $chatRoom = ChatRoom::create([
                'order_id' => $order->id,
                'buyer_id' => $order->user_id,
                'seller_id' => $order->item->user_id,
            ]);
        }

        $chatRoom->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $buyerReviewed = Review::where('order_id', $order->id)
            ->where('reviewer_id', $order->user_id)
            ->exists();

        $sellerReviewed = Review::where('order_id', $order->id)
            ->where('reviewer_id', $order->item->user_id)
            ->exists();

        $messages = $chatRoom->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        $partner = $user->id === $chatRoom->buyer_id
            ? User::find($chatRoom->seller_id)
            : User::find($chatRoom->buyer_id);

        $otherOrders = Order::with('item')
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhereHas('item', function ($q2) use ($user) {
                        $q2->where('user_id', $user->id);
                    });
            })
            ->where('id', '!=', $order->id)
            ->get();

        $isBuyer  = $user->id === $order->user_id;
        $isSeller = $user->id === $order->item->user_id;

        $shouldShowModal = false;
        $flash = session('showReviewModal');

        if ($isBuyer && $flash && !$buyerReviewed) {
            $shouldShowModal = true;
        }

        if ($isSeller && $buyerReviewed && !$sellerReviewed) {
            $shouldShowModal = true;
        }

        return view('chat_purchaser', compact(
            'order',
            'chatRoom',
            'messages',
            'partner',
            'otherOrders',
            'shouldShowModal'
        ));
    }

    public function store(ChatMessageRequest $request, Order $order)
    {

        $chatRoom = ChatRoom::where('order_id', $order->id)->firstOrFail();

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('chat_images', 'public')
            : null;

        ChatMessage::create([
            'chat_room_id' => $chatRoom->id,
            'sender_id'    => auth()->id(),
            'message_text' => $request->message_text,
            'image_path'   => $imagePath,
        ]);

        return back();
    }

    public function edit(Order $order, ChatMessage $chatMessage)
    {
        if ($chatMessage->sender_id !== auth()->id()) {
            abort(403);
        }

        return redirect()
            ->route('trade.chat', $order->id)
            ->with('editingMessageId', $chatMessage->id);
    }

    public function update(Request $request, Order $order, ChatMessage $chatMessage)
    {
        if ($chatMessage->sender_id !== auth()->id()) {
            abort(403);
        }

        $chatMessage->update([
            'message_text' => $request->message_text,
        ]);

        return redirect()->route('trade.chat', $order->id);
    }

    public function destroy(Order $order, ChatMessage $chatMessage)
    {
        if ($chatMessage->sender_id !== auth()->id()) {
            abort(403);
        }

        $chatMessage->delete();

        return redirect()->route('trade.chat', $order->id);
    }

    public function complete(Order $order)
    {

        $order->update([
            'status' => 'completed',
            'is_completed' => true,
        ]);

        $seller = $order->item->user;

        Mail::to($seller->email)
            ->send(new TradeCompletedMail($order));

        return redirect()
            ->route('trade.chat', ['order' => $order->id])
            ->with('showReviewModal', true);
    }

    public function storeReview(Request $request, Order $order)
    {

        $reviewedUserId = auth()->id() === $order->user_id
            ? $order->item->user_id
            : $order->user_id;

        $alreadyReviewed = Review::where('order_id', $order->id)
            ->where('reviewer_id', auth()->id())
            ->exists();

        if (!$alreadyReviewed) {
            Review::create([
                'order_id' => $order->id,
                'reviewer_id' => auth()->id(),
                'reviewed_id' => $reviewedUserId,
                'rating' => $request->rating,
            ]);
        }

        $buyerReviewed = Review::where('order_id', $order->id)
            ->where('reviewer_id', $order->user_id)
            ->exists();

        $sellerReviewed = Review::where('order_id', $order->id)
            ->where('reviewer_id', $order->item->user_id)
            ->exists();

        return redirect()->route('home')->with('success', '評価を送信しました');
    }
}
