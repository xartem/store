<?php

namespace Domain\Auth\Contracts;

interface SendResetPasswordLinkContract
{
    public function __invoke(string $email): bool;
}
