@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="section-header">
        <h1 class="section-title">
            <a href="{{ route('home', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}"
                class="{{ request('tab', 'recommend') === 'recommend' ? 'active' : '' }}">
                おすすめ
            </a>
        </h1>

        <h1 class="section-title">
            <a href="{{ route('home', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
                class="{{ request('tab') === 'mylist' ? 'active' : '' }}">
                マイリスト
            </a>
        </h1>
    </div>

    <div class="item-container">
        @foreach($items as $item)
        <div class="card">
            <a href="{{ route('item.show', $item->id) }}">
                @if ($item->isPurchased())
                <div class="sold-overlay">
                    <span>Sold</span>
                </div>
                @endif

                @if (Str::startsWith($item->item_img, 'http'))
                <img src="{{ $item->item_img }}" alt="{{ $item->item_name }}">
                @else
                <img
                    src="{{ asset('storage/' . $item->item_img) }}"
                    alt="{{ $item->item_name }}"
                    class="{{ $item->isPurchased() ? 'darkened' : '' }}">
                @endif
                <p class="card-title">{{ $item->item_name }}</p>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection