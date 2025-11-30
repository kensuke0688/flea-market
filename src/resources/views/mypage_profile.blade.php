@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage_profile.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="section-header">
        <h1 class="section-title">プロフィール設定</h1>
    </div>

    <form action="{{ route('mypage.profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
        @csrf

        <div class="profile-image-section">
            <div class="profile-image-wrapper">
                @if ($user->profile_img)
                <img id="preview-image" src="{{ asset('storage/' . $user->profile_img) }}" alt="プロフィール画像" class="profile-image">
                @else
                <img id="preview-image" src="{{ asset('img/default-user.png') }}" alt="" class="profile-image">
                @endif
            </div>
            <label for="profile_img" class="image-select-btn">画像を選択する</label>
            <input type="file" name="profile_img" id="profile_img" accept="image/*" hidden>
            @error('profile_img')
            <p class="profile-form__error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form">
            <h2 class="section-item">ユーザー名</h2>
            <input class="profile-form__input"
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $user->name) }}">
            @error('name')
            <p class="profile-form__error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form">
            <h2 class="section-item">郵便番号</h2>
            <input class="profile-form__input"
                type="text"
                name="post_number"
                id="post_number"
                value="{{ old('post_number', $user->post_number) }}">
            @error('post_number')
            <p class="profile-form__error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form">
            <h2 class="section-item">住所</h2>
            <input class="profile-form__input"
                type="text"
                name="address"
                id="address"
                value="{{ old('address', $user->address) }}">
            @error('address')
            <p class="profile-form__error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form">
            <h2 class="section-item">建物名</h2>
            <input class="profile-form__input"
                type="text"
                name="building_name"
                id="building_name"
                value="{{ old('building_name', $user->building_name) }}">
        </div>

        <div class="profile-form__btn-container">
            <input class="profile-form__btn" type="submit" value="更新する">
        </div>
    </form>
</div>

<script>
    document.getElementById('profile_img').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-image'); 

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result; 
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection