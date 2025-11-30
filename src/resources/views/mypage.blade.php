@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="mypage-header">
        <div class="mypage-profile">
            @if ($user->profile_img)
            <img src="{{ asset('storage/' . $user->profile_img) }}" alt="プロフィール画像" class="profile-img">
            @else
            <div class="profile-img default"></div>
            @endif
            <h2 class="user-name">{{ $user->name }}</h2>
        </div>
        <a href="{{ route('mypage.profile') }}" class="profile-edit-btn">プロフィールを編集</a>
    </div>

    <div class="mypage-tabs">
        <a href="{{ route('mypage', ['page' => 'buy']) }}" class="tab {{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
        <a href="{{ route('mypage', ['page' => 'sell']) }}" class="tab {{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
    </div>

    <div class="tab-content {{ $page === 'sell' ? 'active' : '' }}" id="selling">
        <div class="item-list">
            @foreach ($selling_items as $item)
            <div class="item-card">
                @if (Str::startsWith($item->item_img, 'http'))
                <img src="{{ $item->item_img }}" alt="{{ $item->item_name }}">
                @else
                <img src="{{ asset('storage/' . $item->item_img) }}" alt="{{ $item->item_name }}">
                @endif
                <p>{{ $item->item_name }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="tab-content {{ $page === 'buy' ? 'active' : '' }}" id="purchased">
        <div class="item-list">
            @foreach ($purchased_items as $item)
            <div class="item-card">
                @if (Str::startsWith($item->item_img, 'http'))
                <img src="{{ $item->item_img }}" alt="{{ $item->item_name }}">
                @else
                <img src="{{ asset('storage/' . $item->item_img) }}" alt="{{ $item->item_name }}">
                @endif
                <p>{{ $item->item_name }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection