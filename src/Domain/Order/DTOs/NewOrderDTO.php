<?php

namespace Domain\Order\DTOs;

use App\Http\Requests\OrderFormRequest;
use Support\Traits\Makeable;

class NewOrderDTO
{
    use Makeable;

    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $phone,
        public readonly int $delivery_type_id,
        public readonly int $payment_method_id,
        public readonly bool|null $create_account = null,
        public readonly string|null $password = null,
        public readonly string|null $city = null,
        public readonly string|null $address = null,
    ) {
    }

    public static function fromRequest(OrderFormRequest $request): self
    {
        return self::make(
            ...$request->only([
                'first_name', 'last_name', 'email', 'phone', 'delivery_type_id',
                'payment_method_id', 'create_account', 'password', 'city', 'address',
            ])
        );
    }
}
