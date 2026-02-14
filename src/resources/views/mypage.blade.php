@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="mypage-header">
        <div class="mypage-profile">

            @if ($user->profile_img)
            <img src="{{ asset('storage/' . $user->profile_img) }}" class="profile-img">
            @else
            <div class="profile-img default"></div>
            @endif

            <div class="user-info">
                <h2 class="user-name">{{ $user->name }}</h2>

                @if($userReviewCount > 0)
                <div class="user-rating">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <=$userRoundedRating)
                        <span class="star filled">★</span>
                        @else
                        <span class="star empty">★</span>
                        @endif
                        @endfor
                </div>
                @endif
            </div>

        </div>
        <a href="{{ route('mypage.profile') }}" class="profile-edit-btn">プロフィールを編集</a>
    </div>

    <div class="mypage-tabs">
        <a href="{{ route('mypage', ['page' => 'buy']) }}"
            class="tab {{ $page === 'buy' ? 'active' : '' }}">
            購入した商品
        </a>

        <a href="{{ route('mypage', ['page' => 'sell']) }}"
            class="tab {{ $page === 'sell' ? 'active' : '' }}">
            出品した商品
        </a>

        <a href="{{ route('mypage', ['page' => 'trading']) }}"
            class="tab trading {{ $page === 'trading' ? 'active' : '' }}">
            取引中の商品
            @if($unreadTradingCount > 0)
            <span class="badge">
                {{ $unreadTradingCount }}
            </span>
            @endif
        </a>
    </div>

    <div class="tab-content {{ $page === 'trading' ? 'active' : '' }}" id="trading">
        <div class="item-list">
            @forelse ($trading_items as $order)
            @php
            $item = $order->item;

            $unreadCount = $order->chatRoom
            ? $order->chatRoom->messages
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->count()
            : 0;
            @endphp

            <a href="{{ route('trade.chat', $order->id) }}"
                class="item-card link-card">

                {{-- 🔴 未読バッジ --}}
                @if($unreadCount > 0)
                <span class="item-badge">
                    {{ $unreadCount }}
                </span>
                @endif

                @if (Str::startsWith($item->item_img, 'http'))
                <img src="{{ $item->item_img }}" alt="{{ $item->item_name }}">
                @else
                <img src="{{ asset('storage/' . $item->item_img) }}" alt="{{ $item->item_name }}">
                @endif

                <p>{{ $item->item_name }}</p>
            </a>

            @empty
            <p class="empty-text">取引中の商品はありません</p>
            @endforelse
        </div>
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