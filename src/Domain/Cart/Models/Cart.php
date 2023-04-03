<?php

namespace Domain\Cart\Models;

use Database\Factories\CartFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory, MassPrunable;

    protected $fillable = [
        'storage_id', 'user_id',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function prunable(): Builder
    {
        return self::query()->where('created_at', '<=', now()->subDay());
    }

//    public function newCollection(array $models = []): CartCollection
//    {
//        return new CartCollection($models);
//    }
//
//    public function newEloquentBuilder($query): CartQueryBuilder
//    {
//        return new CartQueryBuilder($query);
//    }

    public static function newFactory(): CartFactory
    {
        return CartFactory::new();
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
