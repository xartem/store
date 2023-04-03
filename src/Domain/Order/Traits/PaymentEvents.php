<?php

namespace Domain\Order\Traits;

use Closure;

trait PaymentEvents
{
    protected static Closure $onCreating;

    protected static Closure $onSuccess;

    protected static Closure $onValidating;

    protected static Closure $onError;

    public static function onCreating(Closure $closure): void
    {
        self::$onCreating = $closure;
    }

    public static function onSuccess(Closure $closure): void
    {
        self::$onSuccess = $closure;
    }

    public static function onValidating(Closure $closure): void
    {
        self::$onValidating = $closure;
    }

    public static function onError(Closure $closure): void
    {
        self::$onError = $closure;
    }
}
