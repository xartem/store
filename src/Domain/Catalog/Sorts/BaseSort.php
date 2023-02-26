<?php

namespace Domain\Catalog\Sorts;

use Illuminate\Database\Eloquent\Builder;

class BaseSort extends AbstractSort
{
    public function apply(Builder $query): Builder
    {
        return $query->when($this->existsValue(), function (Builder $q) {
            $q->orderBy($this->queryValue(), $this->getDirection());
        });
    }

    private function existsValue(): bool
    {
        return isset($this->values()[$this->requestValue()]);
    }

    public function values(): array
    {
        return [
            'price' => 'от дешевых к дорогим',
            '-price' => 'от дорогих к дешевым',
            'title' => 'наименованию',
        ];
    }

    public function view(): string
    {
        return 'catalog.sorts.base';
    }
}
