<?php

namespace Domain\Catalog\Models;

use Database\Factories\CategoryFactory;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\HasSlug;

/**
 * @metod static Category|BrandQueryBuilder query()
 */
class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'slug', 'title', 'sorting', 'is_show_on_main_page',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'is_show_on_main_page' => 'boolean',
    ];

    public function newCollection(array $models = []): CategoryCollection
    {
        return new CategoryCollection($models);
    }

    public function newEloquentBuilder($query): CategoryQueryBuilder
    {
        return new CategoryQueryBuilder($query);
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
