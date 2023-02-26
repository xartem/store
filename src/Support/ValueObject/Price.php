<?php

namespace Support\ValueObject;

use InvalidArgumentException;
use Stringable;
use Support\Traits\Makeable;

class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'USD' => '$',
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'USD',
        private readonly int $precision = 100
    ) {
        if ($this->value < 0) {
            throw new InvalidArgumentException("Price {$this->value} must be greater than zero");
        }

        if (! isset($this->currencies[$this->currency])) {
            throw new InvalidArgumentException("Currency {$this->currency} not supported or undefined");
        }
    }

    public function raw(): int
    {
        return $this->value;
    }

    public function value(): int|float
    {
        return $this->value / $this->precision;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function symbol(): string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString(): string
    {
        return number_format($this->value(), 2, '.', ' ')
            .' '.$this->symbol();
    }
}
