<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatus;

class PaidOrderState extends OrderState
{
    protected array $allowedTransitions = [
        CanceledOrderState::class,
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return OrderStatus::PAID->value;
    }

    public function humanValue(): string
    {
        return 'Оплачен';
    }
}
