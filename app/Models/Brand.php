<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'slug', 'title', 'thumbnail',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}