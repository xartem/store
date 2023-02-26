<?php

namespace Domain\Catalog\Providers;

use Domain\Catalog\Filters\BrandFilter;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Filters\PriceFilter;
use Domain\Catalog\Sorts\BaseSort;
use Domain\Catalog\Sorts\SortManager;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ActionServiceProvider::class);
        $this->app->singleton(FilterManager::class);
        $this->app->singleton(SortManager::class);
    }

    public function boot()
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter(),
        ]);

        app(SortManager::class)->registerSorts([
            new BaseSort(),
        ]);
    }
}
