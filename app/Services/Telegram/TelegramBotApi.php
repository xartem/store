<?php

namespace App\Services\Telegram;

use App\Exceptions\Telegram\TelegramBotApiException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    protected Response $http_response;

    protected array $response = [];

    public function __construct(protected $token, protected $chat_id)
    {
    }

    public function sendMessage(string $message): bool
    {
        return $this->send('sendMessage', [
            'chat_id' => $this->chat_id,
            'text' => $message,
        ]);
    }

    private function send(string $command, array $data = [], string $method = 'GET'): bool
    {
        try {
            $this->http_response = Http::send($method, $this->getUrl($command), ['form_params' => $data]);
            $this->response = $this->http_response->json();
            return ! $this->isRequestError();
        } catch (\Throwable $e) {
            report(new TelegramBotApiException('Telegram API request is failed'));
            return false;
        }
    }

    private function getUrl(string $command): string
    {
        return self::HOST.$this->token.'/'.$command;
    }

    private function isRequestError(): bool
    {
        return $this->http_response->failed() || isset($this->response['ok']) && ! $this->response['ok'];
    }
}