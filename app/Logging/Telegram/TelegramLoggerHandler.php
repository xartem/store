<?php

namespace App\Logging\Telegram;

use App\Services\Telegram\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chat_id;

    protected string $token;

    protected TelegramBotApi $telegram;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        $this->chat_id = (int) $config['chat_id'];
        $this->token = $config['token'];
        $this->telegram = new TelegramBotApi($this->token, $this->chat_id);
        parent::__construct($level);
    }

    protected function write(array $record): void
    {
        $this->telegram->sendMessage($record['formatted']);
    }
}
