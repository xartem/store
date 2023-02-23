<?php

namespace Services\Telegram;

use App\Exceptions\Telegram\TelegramBotApiException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TelegramBotApiFake extends TelegramBotApi
{
    protected bool $success = false;

    public function returnTrue(): self
    {
        $this->success = true;

        return $this;
    }

    public function returnFalse(): self
    {
        $this->success = false;

        return $this;
    }

    public function sendMessage(string $message): bool
    {
        return $this->success;
    }
}
