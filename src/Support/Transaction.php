<?php

namespace Support;

use Closure;
use Illuminate\Support\Facades\DB;
use Throwable;

class Transaction
{
    public static function wrap(Closure $callback, Closure $finished = null, Closure $catch = null)
    {
        try {
            DB::beginTransaction();

            return tap($callback(), function ($result) use ($finished) {
                if ($finished !== null) {
                    $finished($result);
                }

                DB::commit();
            });
        } catch (Throwable $e) {
            DB::rollBack();
            if ($catch !== null) {
                $catch($e);
            }

            throw $e;
        }
    }
}
