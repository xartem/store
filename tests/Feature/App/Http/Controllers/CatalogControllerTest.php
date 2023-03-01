<?php

namespace Tests\Feature\App\Http\Controllers;

use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CatalogControllerTest extends TestCase
{
    use RefreshDatabase;

    protected ?Category $category = null;

    protected ?Collection $products = null;

    protected function setUp(): void
    {
        parent::setUp();

        Category::factory(10)->create();

        $this->category = Category::factory()->create();

        $this->products = Product::factory(20)->hasAttached($this->category)->create();
    }

    public function test_page_response_success()
    {
        $this->get(route('catalog', $this->category))
            ->assertViewIs('catalog.index')
            ->assertViewHas('categories')
            ->assertViewHas('products')
            ->assertViewHas('products.0', function (Product $product) {
                return $product->categories()->first()->id === $this->category->id;
            })
            ->assertOk();
    }

    public function test_sort_by_price_title()
    {
        $this->checkSort('title', 'ASC');
    }

    public function test_sort_by_price_asc()
    {
        $this->checkSort('price', 'ASC');
    }

    public function test_sort_by_price_desc()
    {
        $this->checkSort('price', 'DESC');
    }

    private function checkSort(string $column, string $direction)
    {
        $first_product = $direction === 'DESC'
            ? $this->products->sortByDesc($column)->first()
            : $this->products->sortBy($column)->first();

        $this->get(catalog_filter_url($this->category, ['sort' => $direction === 'DESC' ? '-'.$column : $column]))
            ->assertViewHas('products.0', $first_product)
            ->assertOk();
    }
}
