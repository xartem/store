<?php

namespace Services\Telegram;

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
