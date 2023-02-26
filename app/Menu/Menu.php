<?php

namespace App\Menu;

use Countable;
use IteratorAggregate;
use Support\Traits\Makeable;
use Traversable;

class Menu implements IteratorAggregate, Countable
{
    use Makeable;

    protected array $items = [];

    public function __construct(MenuItem ...$items)
    {
        $this->items = $items;
    }

    public function all()
    {
        return collect($this->items);
    }

    public function add(MenuItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function addIf(bool|callable $condition, MenuItem $item): self
    {
        if (is_callable($condition) ? $condition() : $condition) {
            $this->items[] = $item;
        }

        return $this;
    }

    public function remove(MenuItem $item): self
    {
        $this->items = $this->all()
            ->filter(function (MenuItem $current) use ($item) {
                return $current !== $item;
            })->toArray();

        return $this;
    }

    public function removeByLink(string $link)
    {
        $this->items = $this->all()
            ->filter(function (MenuItem $current) use ($link) {
                return $current->link() !== $link;
            })->toArray();

        return $this;
    }

    public function getIterator(): Traversable
    {
        return $this->all();
    }

    public function count(): int
    {
        return count($this->items);
    }
}
