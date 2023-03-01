<?php

namespace Domain\Catalog\Providers;

use Domain\Catalog\Filters\BrandFilter;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Filters\PriceFilter;
use Domain\Catalog\Sorters\Sorter;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ActionServiceProvider::class);
        $this->app->singleton(FilterManager::class);
    }

    public function boot()
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter(),
        ]);

        $this->app->bind(Sorter::class, function () {
            return new Sorter([
                'title', 'price',
            ]);
        });
    }
}
