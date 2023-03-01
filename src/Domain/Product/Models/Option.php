<?php

namespace Domain\Product\Models;

use Database\Factories\OptionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

//    public function newCollection(array $models = []): OptionCollection
//    {
//        return new OptionCollection($models);
//    }
//
//    public function newEloquentBuilder($query): OptionQueryBuilder
//    {
//        return new OptionQueryBuilder($query);
//    }

    public static function newFactory(): OptionFactory
    {
        return OptionFactory::new();
    }
}
