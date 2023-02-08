<?php

namespace App\Listeners;

use App\Notifications\NewUserCreatedNotification;
use Illuminate\Auth\Events\Registered;

class SendEmailNewUserCreatedListener
{
    public function handle(Registered $event)
    {
        $event->user->notify(new NewUserCreatedNotification());
    }
}
