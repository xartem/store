<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class CategoryViewModel
{
    use Makeable;

    public function mainPage(): Collection
    {
        return Cache::rememberForever('category_main_page', function () {
            return Category::mainPage()->limit(10)->get();
        });
    }

    public function catalogPage(): Collection
    {
        return Category::query()
            ->catalogPage()
            ->get();
    }
}
