<?php

namespace Support\Actions;

use App\Events\AfterSessionRegenerated;
use Closure;

class SessionRegenerateAction
{
    public function __invoke(Closure $callback = null): void
    {
        $old = session()->getId();

        session()->invalidate();

        session()->regenerateToken();

        if (is_callable($callback)) {
            $callback();
        }

        event(new AfterSessionRegenerated($old, session()->getId()));
    }
}
