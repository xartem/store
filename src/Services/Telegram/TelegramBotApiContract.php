<?php

namespace Services\Telegram;

interface TelegramBotApiContract
{
    public function sendMessage(string $message): bool;
}
