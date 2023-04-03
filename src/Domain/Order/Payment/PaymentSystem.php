<?php

namespace Domain\Order\Payment;

use Closure;
use Domain\Order\Contracts\PaymentGatewayContract;
use Domain\Order\Exceptions\PaymentGatewayException;
use Domain\Order\Models\Payment;
use Domain\Order\Models\PaymentHistory;
use Domain\Order\States\Payment\PaidPaymentState;
use Domain\Order\Traits\PaymentEvents;

class PaymentSystem
{
    use PaymentEvents;

    protected static PaymentGatewayContract $provider;

    public static function provider(PaymentGatewayContract|Closure $provider): void
    {
        if (is_callable($provider)) {
            $provider = call_user_func($provider);
        }

        if (! $provider instanceof PaymentGatewayContract) {
            throw PaymentGatewayException::providerRequired();
        }

        self::$provider = $provider;
    }

    public static function create(PaymentData $paymentData): PaymentGatewayContract
    {
        if (! self::$provider instanceof PaymentGatewayContract) {
            throw PaymentGatewayException::providerRequired();
        }

        Payment::query()->create(['payment_id' => $paymentData->id()]);

        if (is_callable(self::$onCreating)) {
            call_user_func(self::$onCreating, $paymentData);
        }

        return self::$provider;
    }

    public static function validate(): PaymentGatewayContract
    {
        if (! self::$provider instanceof PaymentGatewayContract) {
            throw PaymentGatewayException::providerRequired();
        }

        PaymentHistory::query()->create([
            'method' => request()->method(),
            'payload' => self::$provider->getRequest(),
            'provider' => self::getProviderName(),
        ]);

        if (is_callable(self::$onValidating)) {
            call_user_func(self::$onValidating);
        }

        if (self::$provider->isValidate() && self::$provider->isPaid()) {
            try {
                $payment = Payment::query()
                    ->where('payment_id', self::$provider->getPaymentId())
                    ->firstOr(function () {
                        throw PaymentGatewayException::paymentNotFound();
                    });

                if (is_callable(self::$onSuccess)) {
                    call_user_func(self::$onSuccess, $payment);
                }

                $payment->state->transitionTo(PaidPaymentState::class);
            } catch (PaymentGatewayException $e) {
                if (is_callable(self::$onError)) {
                    call_user_func(self::$onError, self::$provider->getErrorMessage() ?? $e->getMessage());
                }
            }
        }

        return self::$provider;
    }

    public function getProviderName(): string
    {
        return get_class(self::$provider);
    }
}
