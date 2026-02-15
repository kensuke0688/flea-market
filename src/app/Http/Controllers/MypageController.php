<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Order;
use App\Models\Review;
use App\Models\ChatMessage;

use App\Http\Requests\ProfileRequest;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'buy');
        $selling_items = Item::where('user_id', $user->id)->get();
        $purchased_items = Item::whereHas('orders', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        $trading_items = Order::with(['item', 'chatRoom.messages'])
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhereHas('item', function ($q2) use ($user) {
                        $q2->where('user_id', $user->id);
                    });
            })
            ->get()
            ->sortByDesc(function ($order) {
                return optional($order->chatRoom?->messages->sortByDesc('created_at')->first())->created_at;
            })
            ->values();

        $ratingData = Review::where('reviewed_id', $user->id)
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as review_count')
            ->first();

        $userAverageRating = $ratingData->avg_rating;
        $userReviewCount   = $ratingData->review_count;

        $userRoundedRating = $userAverageRating
            ? round($userAverageRating)
            : null;

        $unreadTradingCount = ChatMessage::whereHas('chatRoom.order', function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhereHas('item', function ($q2) use ($user) {
                    $q2->where('user_id', $user->id);
                });
        })
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->count();

        return view('mypage', compact(
            'user',
            'page',
            'selling_items',
            'purchased_items',
            'trading_items',
            'userAverageRating',
            'userReviewCount',
            'userRoundedRating',
            'unreadTradingCount'
        ));


        $unreadTradingCount = Order::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhereHas('item', function ($q2) use ($user) {
                    $q2->where('user_id', $user->id);
                });
        })
            ->whereHas('chatRoom.messages', function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id)
                    ->where('is_read', false);
            })
            ->count();
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('mypage_profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_img')) {
            $path = $request->file('profile_img')->store('profiles', 'public');
            $user->profile_img = $path;
        }

        $user->fill([
            'post_number'    => $request->post_number,
            'address'        => $request->address,
            'building_name'  => $request->building_name,
        ]);

        $user->name = $request->name;
        $user->save();  

        return redirect('/')->with('success', 'プロフィールを更新しました');
    }
}