<?php

namespace Domain\Catalog\Sorts;

class SortManager
{
    public function __construct(protected array $items = [])
    {
    }

    public function registerSorts(array $items): void
    {
        $this->items = $items;
    }

    public function items(): array
    {
        return $this->items;
    }
}
