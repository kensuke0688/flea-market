<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Http\Requests\ProfileRequest;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $page = $request->query('page', 'buy'); 

        $selling_items = Item::where('user_id', $user->id)->get();

        $purchased_items = Order::where('user_id', $user->id)
            ->with('item')
            ->get()
            ->map(function ($order) {
                return $order->item; 
            });

        return view('mypage', compact('user', 'page', 'selling_items', 'purchased_items'));
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('mypage_profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png'], 
        ]);

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