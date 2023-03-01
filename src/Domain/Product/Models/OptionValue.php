<?php

namespace Domain\Product\Models;

use Database\Factories\OptionValueFactory;
use Domain\Product\Collections\OptionValueCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'option_id', 'title',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function newCollection(array $models = []): OptionValueCollection
    {
        return new OptionValueCollection($models);
    }

//    public function newEloquentBuilder($query): OptionValueQueryBuilder
//    {
//        return new OptionValueQueryBuilder($query);
//    }

    public static function newFactory(): OptionValueFactory
    {
        return OptionValueFactory::new();
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
