<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\DTOs\NewOrderDTO;
use Domain\Order\Models\Order;

class AssignCustomer implements OrderProcessContract
{
    public function __construct(protected NewOrderDTO $newOrderDTO)
    {
    }

    public function handle(Order $order, $next)
    {
        $order->orderCustomer()->create([
            'first_name' => $this->newOrderDTO->first_name,
            'last_name' => $this->newOrderDTO->last_name,
            'email' => $this->newOrderDTO->email,
            'phone' => $this->newOrderDTO->phone,
            'city' => $this->newOrderDTO->city,
            'address' => $this->newOrderDTO->address,
        ]);

        return $next($order);
    }
}
