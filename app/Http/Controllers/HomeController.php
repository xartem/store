<?php

namespace App\Http\Controllers;

use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;
use Domain\Product\ViewModel\ProductViewModel;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('index', [
            'brands' => BrandViewModel::make()->mainPage(),
            'categories' => CategoryViewModel::make()->mainPage(),
            'products' => ProductViewModel::make()->mainPage(),
        ]);
    }
}
