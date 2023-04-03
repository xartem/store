<?php

namespace Domain\Order\States;

use Domain\Order\Events\OrderStatusChanged;
use Domain\Order\Models\Order;
use InvalidArgumentException;

abstract class OrderState
{
    protected array $allowedTransitions = [];

    public function __construct(protected Order $order)
    {
    }

    abstract public function canBeChanged(): bool;

    abstract public function value(): string;

    abstract public function humanValue(): string;

    public function transitionTo(OrderState $orderState): void
    {
        if (! $this->canBeChanged()) {
            throw new InvalidArgumentException('Status can`t be changed');
        }

        if (! in_array(get_class($orderState), $this->allowedTransitions)) {
            throw new InvalidArgumentException(
                "No transition for {$this->order->status->value()} to {$orderState->value()}"
            );
        }

        $this->order->updateQuietly([
            'status' => $orderState->value(),
        ]);

        event(new OrderStatusChanged(
            $this->order, $this->order->status, $orderState
        ));
    }
}
