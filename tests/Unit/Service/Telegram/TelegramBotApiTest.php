<?php

namespace Tests\Unit\Service\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;
use Tests\TestCase;

class TelegramBotApiTest extends TestCase
{
    public function test_send_message_success_by_http_fake(): void
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response(['ok' => true])
        ]);

        $result = (new TelegramBotApi('test', '123'))->sendMessage('Testing');

        $this->assertTrue($result);
    }

    public function test_send_message_success_by_fake_instance(): void
    {
        TelegramBotApi::fake()
            ->returnTrue();

        $result = app(TelegramBotApiContract::class)->sendMessage('Testing');

        $this->assertTrue($result);
    }

    public function test_send_message_fail_by_fake_instance(): void
    {
        TelegramBotApi::fake()
            ->returnFalse();

        $result = app(TelegramBotApiContract::class)->sendMessage('Testing');

        $this->assertFalse($result);
    }

}
