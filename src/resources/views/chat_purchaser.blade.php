<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/chat_purchaser.css') }}">
    <title>Coachtechフリマ</title>
</head>

<header class="header">
    <img src="{{ asset('img/logo.svg') }}" alt="coachtech" width="240" height="80">
</header>

<div class="trade-chat">
    <div class="trade-body">

        {{-- 左サイドバー --}}
        <aside class="trade-sidebar">
            <p class="sidebar-title">その他の取引</p>

            <ul class="other-trade-list">
                @forelse ($otherOrders as $otherOrder)
                <li>
                    <a href="{{ route('trade.chat', $otherOrder->id) }}">
                        {{ $otherOrder->item->item_name }}
                    </a>
                </li>
                @empty
                <li class="empty-text"></li>
                @endforelse
            </ul>
        </aside>

        {{-- メイン --}}
        <main class="trade-main">

            {{-- 取引相手 --}}
            <div class="trade-partner">
                <div class="partner-icon"></div>
                <h2>「{{ $partner->name ?? 'ユーザー名' }}」さんとの取引画面</h2>

                <!-- 【修正】フォームではなく、モーダルを開くボタンにします -->
                @if(auth()->id() === $order->user_id && !$order->is_completed)
                <form method="POST" action="{{ route('trade.complete', $order->id) }}">
                    @csrf
                    <button type="submit" class="complete-btn">
                        取引を完了する
                    </button>
                </form>
                @endif
            </div>

            {{-- 商品情報（★ 画像クリックでチャット遷移する想定） --}}
            {{-- 商品情報 --}}
            <div class="trade-item">
                <div class="item-image">
                    <img src="{{ $order->item->item_img }}"
                        alt="{{ $order->item->item_name }}"
                        class="item-img">
                </div>

                <div class="item-info">
                    <h3 class="item-name">{{ $order->item->item_name }}</h3>
                    <p class="item-price">¥{{ number_format($order->item->price) }}</p>
                </div>
            </div>

            {{-- チャットエリア --}}
            <div class="chat-area">
                @foreach ($messages as $message)

                @if ($message->sender_id === auth()->id())
                <div class="chat-message right">
                    <div class="chat-content">
                        <p class="chat-user-name">{{ $message->sender->name }}</p>

                        <div class="chat-bubble">
                            @if($message->message_text)
                            <p>{{ $message->message_text }}</p>
                            @endif

                            @if($message->image_path)
                            <img src="{{ asset('storage/' . $message->image_path) }}"
                                class="chat-image">
                            @endif
                        </div>

                        {{-- 編集・削除ボタン --}}
                        <div class="message-actions">
                            <a href="{{ route('trade.message.edit',
                ['order' => $order->id, 'chatMessage' => $message->id]) }}"
                                class="action-btn">
                                編集
                            </a>

                            <form method="POST"
                                action="{{ route('trade.message.destroy',
                    ['order' => $order->id, 'chatMessage' => $message->id]) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="action-btn">
                                    削除
                                </button>
                            </form>
                        </div>

                    </div>
                    <div class="chat-user-icon"></div>
                </div>

                @else
                {{-- 相手のメッセージ --}}
                <div class="chat-message left">
                    <div class="chat-user-icon"></div>

                    <div class="chat-content">
                        <p class="chat-user-name">{{ $message->sender->name }}</p>

                        <div class="chat-bubble">
                            @if($message->message_text)
                            <p>{{ $message->message_text }}</p>
                            @endif

                            @if($message->image_path)
                            <img src="{{ asset('storage/' . $message->image_path) }}"
                                class="chat-image">
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @endforeach
            </div>

            {{-- メッセージ送信 --}}
            @if ($errors->any())
            <div class="chat-error">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            <form method="POST"
                action="{{ session('editingMessageId')
            ? route('trade.message.update',
                ['order' => $order->id,
                 'chatMessage' => session('editingMessageId')])
            : route('trade.message.store', $order->id) }}"
                class="chat-form"
                enctype="multipart/form-data">

                @csrf

                @if(session('editingMessageId'))
                @method('PATCH')
                @endif

                <input
                    id="chatInput"
                    type="text"
                    name="message_text"
                    value="{{ session('editingMessageId')
            ? optional($messages->firstWhere('id', session('editingMessageId')))->message_text
            : '' }}"
                    placeholder="取引メッセージを記入してください">

                {{-- 画像ボタンは常に表示 --}}
                <label class="image-upload">
                    画像を追加
                    <input type="file"
                        name="image"
                        hidden
                        onchange="this.form.submit()">
                </label>

                <button type="submit" class="send-btn">
                    @if(session('editingMessageId'))
                    更新å
                    @else
                    <img src="{{ asset('img/send.jpg') }}" alt="送信">
                    @endif
                </button>
            </form>

        </main>
    </div>
</div>

<div id="reviewModal" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h2>取引が完了しました。</h2>
        </div>
        <div class="modal-body">
            <p>今回の取引相手はどうでしたか？</p>
            <form method="POST" action="{{ route('trade.review.store', $order->id) }}">
                @csrf
                <div class="stars">
                    @for($i=1; $i<=5; $i++)
                        <span class="star" data-value="{{ $i }}">★</span>
                        @endfor
                </div>
                <input type="hidden" name="rating" id="ratingInput">
                <div class="modal-footer">
                    <button type="submit" class="review-submit">
                        送信する
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById('reviewModal');
        const shouldShowModal = @json($shouldShowModal);

        if (shouldShowModal) {
            modal.style.display = 'flex';
        }
        console.log("shouldShowModal:", shouldShowModal);
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('ratingInput');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                let value = this.dataset.value;
                ratingInput.value = value;

                stars.forEach(s => {
                    s.classList.remove('active');
                    if (s.dataset.value <= value) {
                        s.classList.add('active');
                    }
                });
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {

        const input = document.getElementById("chatInput");

        if (!input) return;

        // 取引ごとに保存するためキーを分ける
        const storageKey = "chat_draft_{{ $order->id }}";

        // 保存されている内容を復元
        const saved = localStorage.getItem(storageKey);
        if (saved) {
            input.value = saved;
        }

        // 入力が変わるたび保存
        input.addEventListener("input", function() {
            localStorage.setItem(storageKey, input.value);
        });

        // 送信時は削除
        input.closest("form").addEventListener("submit", function() {
            localStorage.removeItem(storageKey);
        });

    });
</script>