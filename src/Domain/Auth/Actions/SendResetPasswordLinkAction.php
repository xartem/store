<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\SendResetPasswordLinkContract;
use Illuminate\Support\Facades\Password;

class SendResetPasswordLinkAction implements SendResetPasswordLinkContract
{
    public function __invoke(string $email): bool
    {
        $status = Password::sendResetLink(['email' => $email]);

        return $status === Password::RESET_LINK_SENT;
    }
}
