<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class BrandViewModel
{
    use Makeable;

    public function mainPage(): Collection
    {
        return Cache::rememberForever('brand_main_page', function () {
            return Brand::mainPage()->get();
        });
    }
}
