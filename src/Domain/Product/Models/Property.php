<?php

namespace Domain\Product\Models;

use Database\Factories\PropertyFactory;
use Domain\Product\Collections\PropertyCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function newCollection(array $models = []): PropertyCollection
    {
        return new PropertyCollection($models);
    }

//    public function newEloquentBuilder($query): PropertyQueryBuilder
//    {
//        return new PropertyQueryBuilder($query);
//    }

    public static function newFactory(): PropertyFactory
    {
        return PropertyFactory::new();
    }
}
