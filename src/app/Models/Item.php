<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'price',
        'description',
        'item_img',
        'condition',
        'brand',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item', 'item_id', 'category_id');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function isPurchasedBy($userId)
    {
        return $this->orders()->where('user_id', $userId)->exists();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
