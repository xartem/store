<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Support\Traits\HasSlug;
use Support\Traits\HasThumbnail;

class Product extends Model
{
    use HasFactory, HasSlug, HasThumbnail;

    protected $fillable = [
        'slug', 'title', 'brand_id', 'thumbnail', 'price', 'sorting', 'is_show_on_main_page',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'is_show_on_main_page' => 'boolean',
        'price' => PriceCast::class
    ];

    public function scopeMainPage(Builder $q): Builder
    {
        return $q->where('is_show_on_main_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
