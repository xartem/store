<?php

namespace Tests\Unit\Service\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Tests\TestCase;

class TelegramBotApiTest extends TestCase
{
    public function test_send_message_success(): void
    {
        Http::fake([
            TelegramBotApi::HOST.'*' => Http::response(['ok' => true]),
        ]);

        $response = (new TelegramBotApi('', 1))->sendMessage('Message');

        $this->assertTrue($response);
    }
}
