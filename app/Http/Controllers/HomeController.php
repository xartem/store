<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('index', [
            'brands' => BrandViewModel::make()->mainPage(),
            'categories' => CategoryViewModel::make()->mainPage(),
            'products' => Product::mainPage()->get(),
        ]);
    }
}
