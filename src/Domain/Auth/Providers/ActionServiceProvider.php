<?php

namespace Domain\Auth\Providers;

use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Actions\SendResetPasswordLinkAction;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Contracts\SendResetPasswordLinkContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterNewUserContract::class => RegisterNewUserAction::class,
        SendResetPasswordLinkContract::class => SendResetPasswordLinkAction::class,
    ];

    public function boot(): void
    {
//        foreach ($this->bindings as $abstract => $binding) {
//            $this->app->bind($abstract, $binding);
//        }
    }
}
