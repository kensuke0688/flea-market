@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')
<div class="item-detail-container">

    <div class="item-image">
        @if (Str::startsWith($item->item_img, 'http'))
        <img src="{{ $item->item_img }}" alt="{{ $item->item_name }}" class="item-img">
        @else
        <img src="{{ asset('storage/' . $item->item_img) }}" alt="{{ $item->item_name }}" class="item-img">
        @endif
    </div>

    <div class="item-info">
        <h2 class="item-name">{{ $item->item_name }}</h2>
        <p class="brand">{{ $item->brand }}</p>
        <p class="price">¥{{ number_format($item->price) }} <span>(税込)</span></p>

        <div class="item-interactions">
            <div class="favorite-form">
                <form action="{{ route('items.favorite', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="like-btn">
                        @if(auth()->check() && auth()->user()->hasFavorited($item->id))
                        <i class="fa-solid fa-star"></i>
                        @else
                        <i class="fa-regular fa-star"></i>
                        @endif
                    </button>
                </form>
                <span class="like-count">{{ $item->favoritedBy->count() ?? 0 }}</span>
            </div>
            
            <div class="comment-wrapper">
                <i class="fa-regular fa-comment"></i>
                <span class="comment-count">{{ $item->comments_count ?? 0 }}</span>
            </div>
        </div>

        <a href="{{ route('purchase.show', $item->id) }}" class="buy-btn">購入手続きへ</a>

        <div class="description">
            <h3>商品説明</h3>
            <p>{{ $item->description }}</p>
        </div>

        <div class="item-meta">
            <h3>商品の情報</h3>
            <p>カテゴリー:
                @forelse($item->categories as $category)
                <span class="tag">{{ $category->name }}</span>
                @empty
                <span class="tag">未設定</span>
                @endforelse
            </p>
            <p>商品の状態: {{ $item->condition }}</p>
        </div>

        <div class="comments">
            <h3>コメント ({{ $item->comments_count }})</h3>

            @foreach($item->comments as $comment)
            <div class="comment">
                <div class="comment-user">
                    @if($comment->user && $comment->user->profile_img)
                    <img src="{{ asset('storage/' . $comment->user->profile_img) }}"
                        alt="user icon" class="comment-user-img">
                    @else
                    <div class="comment-user-placeholder"></div>
                    @endif
                    <strong>{{ $comment->user->name ?? '匿名ユーザー' }}</strong>
                </div>
                <p class="comment-body">{{ $comment->comment }}</p>
            </div>
            @endforeach

            @auth
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <textarea name="comment" placeholder="商品へのコメント" ></textarea>
                @error('comment')
                <p class="comment-form__error-message">{{ $message }}</p>
                @enderror
                <button type="submit" class="comment-btn">コメントを送信する</button>
            </form>
            @else
            <p class="login-message">
                コメントを投稿するには <a href="{{ route('login') }}">ログイン</a> が必要です。
            </p>
            @endauth
        </div>
    </div>
</div>
@endsection