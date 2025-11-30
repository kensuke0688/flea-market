<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemPurchaseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');
Route::get('/items/search', [ItemController::class, 'search'])
    ->name('items.search');

// メール認証ルート
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/mypage/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証メールを再送しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// 認証済みユーザールート
Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    Route::get('/mypage/profile', [MypageController::class, 'edit'])->name('mypage.profile');
    Route::post('/mypage/profile', [MypageController::class, 'update'])->name('mypage.profile.update');
    Route::get('/mypage/favorites', [ItemController::class, 'favorites'])->name('items.favorites');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/items/{item}/favorite', [ItemController::class, 'favorite'])->name('items.favorite');
    Route::get('/purchase/{item}', [ItemPurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item}', [ItemPurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/address/{item}', [ItemPurchaseController::class, 'editAddress'])->name('purchase.address');
    Route::put('/purchase/address/{item}', [ItemPurchaseController::class, 'updateAddress'])->name('purchase.address.update');
    Route::get('/sell', [ItemController::class, 'create'])->name('item.sell');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');
// stripeルート
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook']);
});




