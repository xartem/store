<?php

use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Sorts\SortManager;
use Support\Flash\Flash;

if (! function_exists('sorts')) {
    function sorts(): array
    {
        return app(SortManager::class)->items();
    }
}

if (! function_exists('filters')) {
    function filters(): array
    {
        return app(FilterManager::class)->items();
    }
}

if (! function_exists('flash')) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}
