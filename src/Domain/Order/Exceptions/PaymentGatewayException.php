<?php

namespace Domain\Order\Exceptions;

use Exception;

class PaymentGatewayException extends Exception
{
    public static function providerRequired(): self
    {
        return new static('Payment provider must be an instance of PaymentGatewayContract');
    }

    public static function paymentNotFound(): self
    {
        return new static('Payment not found');
    }
}
