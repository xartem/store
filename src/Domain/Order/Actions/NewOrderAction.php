<?php

namespace Domain\Order\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Order\DTOs\NewOrderDTO;
use Domain\Order\Models\Order;

class NewOrderAction
{
    public function __invoke(NewOrderDTO $newOrderDTO): Order
    {
        $registerAction = app(RegisterNewUserContract::class);

        if ($newOrderDTO->create_account) {
            $registerAction(NewUserDTO::make(
                $newOrderDTO->first_name, $newOrderDTO->email, $newOrderDTO->password
            ));
        }

        return Order::query()->create([
            'user_id' => auth()->id(),
            'amount' => cart()->amount(),
            'payment_method_id' => $newOrderDTO->payment_method_id,
            'delivery_type_id' => $newOrderDTO->delivery_type_id,
        ]);
    }
}
