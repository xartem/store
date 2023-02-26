<?php

namespace Domain\Product\ViewModel;

use Domain\Catalog\Models\Brand;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class ProductViewModel
{
    use Makeable;

    public function mainPage(): Collection
    {
        return Cache::rememberForever('product_main_page', function () {
            return Product::mainPage()->get();
        });
    }
}
