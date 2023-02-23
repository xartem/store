<?php

namespace Support\Traits;

trait Makeable
{
    public static function make(mixed ...$arguments): self
    {
        return new static(...$arguments);
    }
}