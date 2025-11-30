@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="section-header">
        <h1 class="section-title">
            <a href="{{ url('/') }}{{ request('q') ? '?q=' . request('q') : '' }}" class="{{ request()->is('/') ? 'active' : '' }}">おすすめ</a>
        </h1>
        <h1 class="section-title">
            <a href="{{ route('items.favorites') }}{{ request('q') ? '?q=' . request('q') : '' }}" class="{{ request()->is('mypage/favorites') ? 'active' : '' }}">マイリスト</a>
        </h1>
    </div>

    <div class="item-container">
        @foreach($items as $item)
        <div class="card">
            <a href="{{ route('item.show', $item->id) }}">
                @if ($item->isPurchasedBy(auth()->id()))
                <div class="sold-overlay">
                    <span>Sold</span>
                </div>
                @endif

                @if (Str::startsWith($item->item_img, 'http'))
                <img src="{{ $item->item_img }}" alt="{{ $item->item_name }}">
                @else
                <img src="{{ asset('storage/' . $item->item_img) }}" alt="{{ $item->item_name }}" class="{{ $item->isPurchasedBy(auth()->id()) ? 'darkened' : '' }}">
                @endif
                <p class="card-title">{{ $item->item_name }}</p>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection