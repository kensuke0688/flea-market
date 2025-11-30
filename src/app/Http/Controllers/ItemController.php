<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $items = Item::with('orders')
            ->where('user_id', '!=', $userId)
            ->get();
        return view('index', compact('items'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $items = Item::when($keyword, function ($query) use ($keyword) {
            return $query->where('item_name', 'LIKE', "%{$keyword}%");
        })->get();

        return view('index', compact('items', 'keyword'));
    }

    public function show($item_id)
    {
        $item = Item::with(['comments.user'])->withCount('comments')->findOrFail($item_id);
        return view('item_detail', compact('item'));
    }

    public function favorite(Item $item)
    {
        $user = auth()->user();

        if($user->hasFavorited($item->id)){
            $item->favoritedBy()->detach($user->id);
        }else{
            $item->favoritedBy()->attach($user->id);
        }

        return redirect()->back();
    }

    public function favorites()
    {
        $user = auth()->user();
        $items = $user->favorites()->get();

        return view('index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('item_sell', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();

        $path = $request->file('item_img')->store('items', 'public');

        $item = Item::create([
            'user_id' => Auth::id(),
            'item_name' => $request->item_name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
            'item_img' => $path,
        ]);

        if ($request->has('category')) {
            $item->categories()->sync($request->category);
        }

        return redirect()->route('home')->with('success', '商品を出品しました！');
    }
}