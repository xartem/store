<?php

namespace Domain\Order\Contracts;

use Domain\Order\Payment\PaymentData;
use Illuminate\Http\JsonResponse;

interface PaymentGatewayContract
{
    public function getPaymentId(): string;

    public function setConfig(array $config): void;

    public function setPaymentData(PaymentData $data): self;

    public function getRequest(): mixed;

    public function getResponse(): JsonResponse;

    public function getUrl(): string;

    public function isValidate(): bool;

    public function isPaid(): bool;

    public function getErrorMessage(): string;
}
