<?php

namespace Domain\Catalog\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Stringable;

abstract class AbstractSort implements Stringable
{
    public function __invoke(Builder $query, $next)
    {
        $this->apply($query);

        $next($query);
    }

    // abstract public function title(): string;

    // abstract public function key(): string;

    abstract public function apply(Builder $query): Builder;

    abstract public function values(): array;

    abstract public function view(): string;

    public function requestValue(string $index = null, mixed $default = null): mixed
    {
        $index = str('sort')
            ->when($index, fn ($str) => $str->append(".$index"))
            ->value();

        return request($index, $default);
    }

    protected function queryValue(string $index = null, mixed $default = null): mixed
    {
        return str($this->requestValue($index, $default))
            ->remove('-')
            ->value();
    }

    public function getDirection(): string
    {
        return str($this->requestValue())->contains('-') ? 'DESC' : 'ASC';
    }

    public function name(string $index = null): string
    {
        return 'sort';
    }

    public function id(string $index = null): string
    {
        return str($this->name($index))
            ->slug('_')
            ->value();
    }

    public function __toString(): string
    {
        return view($this->view(), [
            'sort' => $this,
        ])->render();
    }
}
