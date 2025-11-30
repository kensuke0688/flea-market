@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_sell.css') }}">
@endsection

@section('content')

<div class="sell-container">
    <h1 class="sell-title">商品の出品</h1>

    <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-section">
            <label for="item_img">商品画像</label>
            <div class="image-upload-box">
                <input type="file" name="item_img" id="item_img" accept="image/*" hidden>
                <label for="item_img" class="upload-label">画像を選択する</label>
            </div>
            @error('item_img')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-section">
            <h2>商品の詳細</h2>
            <label>カテゴリー</label>
            <div class="category-list">
                @foreach ($categories as $category)
                <label class="category-item">
                    <input type="checkbox" name="category[]" value="{{ $category->id }}">
                    <span>{{ $category->name }}</span>
                </label>
                @endforeach
                @error('category')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <label for="condition">商品の状態</label>
            <select name="condition" id="condition">
                <option value="">選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
            @error('condition')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-section">
            <h2>商品名と説明</h2>

            <label for="item_name">商品名</label>
            <input type="text" name="item_name" id="item_name">
            @error('item_name')
            <p class="error">{{ $message }}</p>
            @enderror

            <label for="brand">ブランド名</label>
            <input type="text" name="brand" id="brand">

            <label for="description">商品の説明</label>
            <textarea name="description" id="description" rows="4"></textarea>
            @error('description')
            <p class="error">{{ $message }}</p>
            @enderror

            <label for="price">販売価格</label>
            <div class="price-input">
                <span class="yen-mark">¥</span>
                <input type="price" name="price" id="price" min="0" step="1">
                @error('price')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <button type="submit" class="submit-btn">出品する</button>
    </form>
</div>
@endsection