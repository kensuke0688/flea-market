@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address_edit.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="section-header">
        <h1 class="section-title">住所の変更</h1>
    </div>

    <form action="{{ route('purchase.address.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="address-form">
            <h2 class="section-item">郵便番号</h2>
            <input class="address-form__input" type="text" name="post_number" id="post_number" required>
            <p class="address-form__error-message">
                @error('post_number')
                {{ $message }}
                @enderror
            </p>
        </div>

        <div class="address-form">
            <h2 class="section-item">住所</h2>
            <input class="address-form__input" type="text" name="address" id="address" required>
            <p class="address-form__error-message">
                @error('address')
                {{ $message }}
                @enderror
            </p>
        </div>

        <div class="address-form">
            <h2 class="section-item">建物名</h2>
            <input class="address-form__input" type="text" name="building_name" id="building_name">
            <p class="address-form__error-message">
                @error('building_name')
                {{ $message }}
                @enderror
            </p>
        </div>

        <div class="address-form__btn-container">
            <input class="address-form__btn" type="submit" value="更新する">
        </div>
    </form>
</div>

@endsection