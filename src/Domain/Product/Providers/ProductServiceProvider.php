<?php

namespace Domain\Product\Providers;

use Domain\Catalog\Providers\ActionServiceProvider;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->app->register(ActionServiceProvider::class);
    }

    public function boot()
    {
    }
}
