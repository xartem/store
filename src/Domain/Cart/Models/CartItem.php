<?php

namespace Domain\Cart\Models;

use Database\Factories\CartItemFactory;
use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Support\ValueObject\Price;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id', 'product_id', 'quantity', 'price', 'string_option_values',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

//    public function newCollection(array $models = []): CartItemCollection
//    {
//        return new CartItemCollection($models);
//    }
//
//    public function newEloquentBuilder($query): CartItemQueryBuilder
//    {
//        return new CartItemQueryBuilder($query);
//    }

    public static function newFactory(): CartItemFactory
    {
        return CartItemFactory::new();
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn () => Price::make($this->price->raw() * $this->quantity)
        );
    }
}
