<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = [
        'order_id',
        'buyer_id',
        'seller_id'
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
