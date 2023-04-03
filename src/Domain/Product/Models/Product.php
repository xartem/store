<?php

namespace Domain\Product\Models;

use Database\Factories\ProductFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Collections\ProductCollection;
use Domain\Product\Jobs\MakeProductJsonPropertiesJob;
use Domain\Product\QueryBuilders\ProductQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;
use Support\Casts\PriceCast;
use Support\Traits\HasSlug;
use Support\Traits\HasThumbnail;

class Product extends Model
{
    use HasFactory, HasSlug, HasThumbnail, Searchable;

    protected $fillable = [
        'slug', 'title', 'description', 'brand_id', 'thumbnail', 'price', 'sorting', 'is_show_on_main_page',
        'json_properties', 'quantity',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'is_show_on_main_page' => 'boolean',
        'json_properties' => 'array',
        'price' => PriceCast::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function (Product $product) {
            MakeProductJsonPropertiesJob::dispatch($product)
                ->delay(now()->addSeconds(10));
        });
    }

    public function newCollection(array $models = []): ProductCollection
    {
        return new ProductCollection($models);
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    public static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    #[SearchUsingFullText(['title', 'description'])]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }
}
