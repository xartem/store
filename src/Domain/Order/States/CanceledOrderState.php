<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatus;

class CanceledOrderState extends OrderState
{
    protected array $allowedTransitions = [];

    public function canBeChanged(): bool
    {
        return false;
    }

    public function value(): string
    {
        return OrderStatus::CANCELED->value;
    }

    public function humanValue(): string
    {
        return 'Отменен';
    }
}
