<?php

namespace App\Http\Controllers;

use Domain\Order\Payment\PaymentData;
use Domain\Order\Payment\PaymentSystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Support\ValueObject\Price;

class PaymentController extends Controller
{
    public function index(): RedirectResponse
    {
        $payment = new PaymentData(
            id: '123456789',
            amount: Price::make(10000),
            description: 'Test payment',
            returnUrl: route('cart'),
            meta: collect(['test' => 'test'])
        );

        return redirect()->away(PaymentSystem::create($payment)->getUrl());
    }

    public function callback(): JsonResponse
    {
        return PaymentSystem::validate()->getResponse();
    }
}
