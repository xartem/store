<?php

namespace Domain\Order\Payment\Providers;

use Domain\Order\Contracts\PaymentGatewayContract;
use Domain\Order\Payment\PaymentData;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

class UnitPay implements PaymentGatewayContract
{
    protected PaymentData $paymentData;

    protected Client $client;

    protected string $message;

    public function __construct(array $config)
    {
        $this->client = new Client();

        $this->setConfig($config);
    }

    public function getUrl(): string
    {
        return 'https://unitpay.com/pay/'.$this->paymentData->id();
    }

    public function getResponse(): JsonResponse
    {
        return response()->json($this->client->response()->getContent());
    }

    public function getPaymentId(): string
    {
        return $this->paymentData->id();
    }

    public function setConfig(array $config): void
    {
        $this->setAuth(...$config);
    }

    public function setPaymentData(PaymentData $data): self
    {
        $this->paymentData = $data;

        return $this;
    }

    public function getRequest(): mixed
    {
        // return request()->all();
        return json_decode(file_get_contents('php://input'), true);
    }

    public function isValidate(): bool
    {
        return $this->client->check($this->paymentData->amount()->value());
    }

    public function isPaid(): bool
    {
        return $this->client->isSuccess();
    }

    public function getErrorMessage(): string
    {
        return $this->message;
    }

    private function setAuth(string $publicKey, string $secretKey): void
    {
        //
    }
}
