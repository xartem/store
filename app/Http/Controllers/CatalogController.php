<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\ViewModel\ProductViewModel;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __invoke(?Category $category): View
    {
        return view('catalog.index', [
            'products' => ProductViewModel::make()->catalogPage($category),
            'categories' => CategoryViewModel::make()->catalogPage(),
            'category' => $category,
        ]);
    }
}
