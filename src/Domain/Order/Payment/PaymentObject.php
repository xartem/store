<?php

namespace Domain\Order\Payment;

use Illuminate\Support\Collection;
use Support\ValueObject\Price;

class PaymentObject
{
    public function __construct(
        protected readonly string $id,
        protected readonly string $status,
        protected readonly Price $amount,
        protected readonly string $description,
        protected readonly Collection $meta,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function amount(): Price
    {
        return $this->amount;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function meta(): Collection
    {
        return $this->meta;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'amount' => $this->amount->value(),
            'description' => $this->description,
            'meta' => $this->meta->toArray(),
        ];
    }
}
