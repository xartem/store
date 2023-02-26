<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __invoke(?Category $category): View
    {
        return view('catalog.index', [
            'products' => Product::query()
                ->catalogPage($category)
                ->paginate(6),
            'categories' => Category::query()
                ->catalogPage()
                ->get(),
            'category' => $category,
        ]);
    }
}
