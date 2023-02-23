<?php

namespace Domain\Catalog\Providers;

use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Actions\SendResetPasswordLinkAction;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Contracts\SendResetPasswordLinkContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    public array $bindings = [
        // RegisterNewUserContract::class => RegisterNewUserAction::class,
    ];
}
