<?php

namespace Support\Flash;

use Illuminate\Contracts\Session\Session;

class Flash
{
    const MESSAGE_KEY = 'flash_shop_message';

    const MESSAGE_CLASS_KEY = 'flash_shop_message_class';

    public function __construct(protected Session $session)
    {
    }

    public function get(): ?FlashMessage
    {
        if ($this->session->missing(self::MESSAGE_KEY)) {
            return null;
        }

        return new FlashMessage(
            $this->session->get(self::MESSAGE_KEY),
            $this->session->get(self::MESSAGE_CLASS_KEY, ''),
        );
    }

    public function info(string $message)
    {
        $this->flash('info', $message);
    }

    public function alert(string $message)
    {
        $this->flash('alert', $message);
    }

    private function flash(string $name, string $message)
    {
        $this->session->flash(self::MESSAGE_KEY, $message);
        $this->session->flash(self::MESSAGE_CLASS_KEY, config("flash.$name", ''));
    }
}
