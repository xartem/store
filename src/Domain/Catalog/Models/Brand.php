<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\HasSlug;
use Support\Traits\HasThumbnail;

/**
 * @metod static Brand|BrandQueryBuilder query()
 */
class Brand extends Model
{
    use HasFactory, HasSlug, HasThumbnail;

    protected $fillable = [
        'slug', 'title', 'thumbnail', 'sorting', 'is_show_on_main_page',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'is_show_on_main_page' => 'boolean',
    ];

    public function newEloquentBuilder($query): BrandQueryBuilder
    {
        return new BrandQueryBuilder($query);
    }

    protected static function newFactory(): BrandFactory
    {
        return BrandFactory::new();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
