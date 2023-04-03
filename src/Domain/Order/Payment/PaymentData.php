<?php

namespace Domain\Order\Payment;

use Illuminate\Support\Collection;
use Support\ValueObject\Price;

class PaymentData
{
    public function __construct(
        protected readonly string $id,
        protected readonly Price $amount,
        protected readonly string $description,
        protected readonly string $returnUrl,
        protected readonly Collection $meta,

    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function amount(): Price
    {
        return $this->amount;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function returnUrl(): string
    {
        return $this->returnUrl;
    }

    public function meta(): Collection
    {
        return $this->meta;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount->value(),
            'description' => $this->description,
            'returnUrl' => $this->returnUrl,
            'meta' => $this->meta->toArray(),
        ];
    }
}
