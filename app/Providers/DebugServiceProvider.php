<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class DebugServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Model::shouldBeStrict(! $this->app->isProduction());

        if ($this->app->isProduction()) {
            DB::whenQueryingForLongerThan(CarbonInterval::seconds(3), function (Connection $connection) {
                logger()->channel(config('logging.debug'))->debug('whenQueryingForLongerThan: '.$connection->totalQueryDuration());
            });

            DB::listen(function ($query) {
                if ($query->time > 100) {
                    logger()->channel(config('logging.debug'))->debug('When Query Longer: '.$query->sql, $query->bindings);
                }
            });

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(3),
                function () {
                    logger()->channel(config('logging.debug'))->debug('whenRequestLifecycleIsLongerThan: '.request()->url());
                }
            );
        }
    }
}
