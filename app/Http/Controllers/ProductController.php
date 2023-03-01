<?php

namespace App\Http\Controllers;

use Domain\Product\Actions\StoreViewedProductAction;
use Domain\Product\Models\Product;
use Domain\Product\ViewModel\ProductViewModel;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product, StoreViewedProductAction $storeViewedProductAction): View
    {
        $product->load('optionValues.option');

        $storeViewedProductAction($product);

        return view('product.show', [
            'product' => $product,
            'options' => $product->optionValues->groupByOptionTitle(),
            'views' => ProductViewModel::make()->viewedProducts($product),
        ]);
    }
}
