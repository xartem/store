<?php

namespace Domain\Product\ViewModel;

use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class ProductViewModel
{
    use Makeable;

    public function mainPage(): Collection
    {
        return Cache::rememberForever('product_main_page', function () {
            return Product::mainPage()->limit(6)->get();
        });
    }

    public function catalogPage(?Category $category): LengthAwarePaginator
    {
        return Product::query()
            ->catalogPage()
            ->whereCategory($category)
            ->search(request('s'))
            ->filtered()
            ->sorted()
            ->paginate(6);
    }

    public function viewedProducts(?Product $current_product = null): Collection
    {
        return Product::query()
            ->views($current_product)
            ->limit(10)
            ->get();
    }
}
