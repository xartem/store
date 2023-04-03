<?php

namespace Domain\Order\Enums;

use Domain\Order\Models\Order;
use Domain\Order\States\CanceledOrderState;
use Domain\Order\States\NewOrderState;
use Domain\Order\States\OrderState;
use Domain\Order\States\PaidOrderState;
use Domain\Order\States\PendingOrderState;

enum OrderStatus: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELED = 'canceled';

    public function createState(Order $order): OrderState
    {
        return match ($this) {
            self::NEW => new NewOrderState($order),
            self::PENDING => new PendingOrderState($order),
            self::PAID => new PaidOrderState($order),
            self::CANCELED => new CanceledOrderState($order),
        };
    }
}
