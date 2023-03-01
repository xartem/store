<?php

namespace Domain\Catalog\Sorters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Stringable;

class Sorter
{
    public const SORT_KEY = 'sort';

    protected ?Stringable $selected_column = null;

    public function __construct(
        protected array $columns = []
    ) {
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->isColumnExist(), function (Builder $q) {
            $q->orderBy($this->queryColumn(), $this->getDirection());
        });
    }

    private function isColumnExist(): bool
    {
        return in_array($this->queryColumn(), $this->columns());
    }

    private function getDirection(): string
    {
        return $this->selectedColumn()->contains('-') ? 'DESC' : 'ASC';
    }

    public function key(): string
    {
        return self::SORT_KEY;
    }

    public function columns(): array
    {
        return $this->columns;
    }

    private function queryColumn(): string
    {
        return $this->selectedColumn()->remove('-');
    }

    private function selectedColumn(): Stringable
    {
        if (! $this->selected_column) {
            $this->selected_column = request()->str($this->key());
        }

        return $this->selected_column;
    }

    public function isActive(string $column, string $direction = 'ASC'): bool
    {
        if (strtoupper($direction) === 'DESC') {
            $column = '-'.$column;
        }

        return $this->selectedColumn()->value() === $column;
    }
}
