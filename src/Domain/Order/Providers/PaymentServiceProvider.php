<?php

namespace Domain\Order\Providers;

use Domain\Order\Models\Payment;
use Domain\Order\Payment\PaymentData;
use Domain\Order\Payment\PaymentSystem;
use Domain\Order\Payment\Providers\UnitPay;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        PaymentSystem::provider(function () {
            return new UnitPay(config('payment.providers.unitpay'));
        });

        PaymentSystem::onCreating(function (PaymentData $paymentData) {
            return $paymentData;
        });

        PaymentSystem::onSuccess(function (Payment $payment) {
            //
        });

        PaymentSystem::onError(function (string $message) {
            //
        });

        PaymentSystem::onValidating(function () {
            //
        });
    }
}
