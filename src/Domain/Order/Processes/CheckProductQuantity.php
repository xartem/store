<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;
use Domain\Order\Models\Order;

class CheckProductQuantity implements OrderProcessContract
{
    public function handle(Order $order, $next)
    {
        foreach (cart()->items() as $item) {
            if ($item->product->quantity < $item->quantity) {
                throw new OrderProcessException('Not enough quantity');
            }
        }

        return $next($order);
    }
}
