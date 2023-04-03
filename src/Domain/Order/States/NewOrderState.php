<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatus;

class NewOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PendingOrderState::class,
        CanceledOrderState::class,
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return OrderStatus::NEW->value;
    }

    public function humanValue(): string
    {
        return 'Новый заказ';
    }
}
