<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatus;

class PendingOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CanceledOrderState::class,
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return OrderStatus::PENDING->value;
    }

    public function humanValue(): string
    {
        return 'В обработке';
    }
}
