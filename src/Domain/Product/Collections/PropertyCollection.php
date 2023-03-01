<?php

namespace Domain\Product\Collections;

use Domain\Product\Models\Property;
use Illuminate\Database\Eloquent\Collection;

class PropertyCollection extends Collection
{
    public function mapTitleWithPivotValue(): \Illuminate\Support\Collection
    {
        return $this->mapWithKeys(
            fn (Property $property) => [$property->title => $property->pivot->value]
        );
    }
}
