<?php

namespace Domain\Product\Actions;

use Domain\Product\Models\Product;

class StoreViewedProductAction
{
    public function __invoke(Product $product)
    {
        $this->run($product);
    }

    public function run(Product $product): void
    {
        session()->push('product.views', $product->id);
    }
}
