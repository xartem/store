<?php

use Domain\Cart\CartManager;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Models\Category;
use Domain\Catalog\Sorters\Sorter;
use Support\Flash\Flash;

if (! function_exists('cart')) {
    function cart(): CartManager
    {
        return app(CartManager::class);
    }
}

if (! function_exists('sorter')) {
    function sorter(): Sorter
    {
        return app(Sorter::class);
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

if (! function_exists('is_catalog_view_type')) {
    function is_catalog_view_type(string $view_type, $default = 'grid'): bool
    {
        return session('view_type', $default) === $view_type;
    }
}

if (! function_exists('catalog_filter_url')) {
    function catalog_filter_url(?Category $category, array $params = []): string
    {
        return route('catalog', [
            ...request()->only(['filters', 'sort']),
            ...$params,
            'category' => $category,
        ]);
    }
}
