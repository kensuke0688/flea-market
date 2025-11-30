@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_purchase.css') }}">
@endsection

@section('content')
<form action="{{ route('payment.checkout') }}" method="POST">
    @csrf
    <input type="hidden" name="item_id" value="{{ $item->id }}">

    <div class="purchase-container">
        <div class="purchase-left">
            <div class="item-summary">
                @if (Str::startsWith($item->item_img, 'http'))
                <img src="{{ $item->item_img }}" alt="{{ $item->item_name }}" class="item-img">
                @else
                <img src="{{ asset('storage/' . $item->item_img) }}" alt="{{ $item->item_name }}" class="item-img">
                @endif

                <div class="item-info">
                    <h2>{{ $item->item_name }}</h2>
                    <p class="price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <div class="payment-section">
                <h3>支払い方法</h3>
                <select name="payment_method" id="payment-select">
                    <option value="">選択してください</option>
                    <option value="konbini">コンビニ払い</option>
                    <option value="card">クレジットカード</option>
                </select>
                @error('payment_method')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="address-section">
                <h3>配送先</h3>
                <p>
                    〒 {{ auth()->user()->post_number ?? '未登録' }}<br>
                    {{ auth()->user()->address ?? '未登録の住所です' }}<br>
                    {{ auth()->user()->building_name ?? '' }}
                </p>
                @error('address')
                <p class="error-message">{{ $message }}</p>
                @enderror
                <a href="{{ route('purchase.address', ['item' => $item->id]) }}" class="change-address">変更する</a>
            </div>
        </div>

        <div class="purchase-right">
            <div class="summary-box">
                <p>商品代金 <span>¥{{ number_format($item->price) }}</span></p>
                <p>支払い方法 <span id="selected-method">未選択</span></p>
            </div>

            <button type="submit" class="purchase-btn">購入する</button>
        </div>

    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const paymentSelect = document.getElementById('payment-select');
        const selectedMethodText = document.getElementById('selected-method');

        paymentSelect.addEventListener('change', function() {
            selectedMethodText.textContent = this.options[this.selectedIndex].text || '未選択';
        });
    });
</script>

@endsection